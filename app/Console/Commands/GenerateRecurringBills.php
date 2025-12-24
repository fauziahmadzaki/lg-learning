<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Bill;
use App\Services\TransactionService;
use App\Services\WhatsApp\WhatsAppServiceInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GenerateRecurringBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bills:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new bills for students who have reached their next billing date';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppServiceInterface $waService)
    {
        $today = now();
        $this->info("Generating bills for date: " . $today->format('Y-m-d'));

        // Cari Siswa Aktif yang next_billing_date <= Hari Ini
        // Artinya sudah waktunya bayar lagi.
        $students = Student::where('status', 'active')
                           ->whereDate('next_billing_date', '<=', $today)
                           ->whereNotNull('next_billing_date')
                           ->get(); // Hati-hati kalau data ribuan, pake chunk()

        $this->info("Found {$students->count()} students needing new bills.");

        foreach ($students as $student) {
            DB::beginTransaction();
            try {
                // Double check biar gak duplikat tagihan di hari yang sama/ periode sama?
                // Idealnya check Bill terakhir student ini, apakah due_date nya sama dengan next_billing_date si student?
                $existingBill = Bill::where('student_id', $student->id)
                                    ->whereDate('due_date', $student->next_billing_date)
                                    ->first();

                if ($existingBill) {
                    $this->warn("Student {$student->name} already has bill for {$student->next_billing_date->format('Y-m-d')}. Skipping.");
                    DB::rollBack();
                    continue;
                }

                $package = $student->package;
                if (!$package) {
                    $this->error("Student {$student->name} has no package. Skipping.");
                    DB::rollBack();
                    continue;
                }

                // CHECK: Apakah paket sudah selesai?
                if ($student->join_date) {
                    $endDate = $student->join_date->copy()->addDays($package->duration);
                    
                    // Jika Next Billing Date sudah melewati/sama dengan End Date, jangan tagih lagi.
                    // Artinya paket sudah habis.
                    if ($student->next_billing_date->greaterThanOrEqualTo($endDate)) {
                        $this->info("Student {$student->name} package finished (End Date: {$endDate->format('Y-m-d')}). Marking as finished.");
                        
                        // Update status jadi finished agar tidak dicek lagi besok
                        $student->update([
                            'status' => 'finished'
                        ]);
                        
                        // Kirim WA Notif Finished? (Opsional, di processPaymentSuccess sudah ada, tapi ini kasus auto-finish by time)
                        // Boleh ditambahkan di sini jika perlu.

                        DB::commit();
                        continue;
                    }
                }

                // Kalkulasi Amount (Sama kayak di Register & BillingService)
                $isDailyRate = $package->duration < 30;
                $amount = $package->price;

                if ($student->billing_cycle === 'weekly') {
                    $amount = $isDailyRate ? ($package->price * 7) : ceil($package->price / 4);
                } elseif ($student->billing_cycle === 'daily') {
                    $amount = $isDailyRate ? $package->price : ceil($package->price / 30);
                } elseif ($student->billing_cycle === 'monthly') {
                    $amount = $isDailyRate ? ($package->price * 30) : $package->price;
                } elseif ($student->billing_cycle === 'full') {
                     if ($isDailyRate) {
                        $amount = $package->price * $package->duration;
                     } else {
                        $months = ceil($package->duration / 30);
                        // Asumsi: Full payment = selesai.
                        $amount = $package->price * ($months > 0 ? $months : 1);
                     }
                }

                // 1. Buat Bill
                $bill = Bill::create([
                    'student_id' => $student->id,
                    'branch_id' => $student->branch_id,
                    'title'      => "Tagihan Periode " . $student->next_billing_date->format('d M Y'),
                    'amount'     => $amount,
                    'due_date'   => $student->next_billing_date,
                    'status'     => 'UNPAID', // Pending Payment
                ]);

                // 2. Generate Transaction (Pending)
                $invoiceCode = 'INV-REC-' . time() . '-' . $student->id;
                $transaction = $student->transactions()->create([
                    'branch_id'    => $student->branch_id,
                    'invoice_code' => $invoiceCode,
                    'total_amount' => $amount,
                    'status'       => 'PENDING',
                    'payment_url'  => '#',
                    'transaction_date' => now(),
                ]);

                // 3. Create Xendit Invoice (Optional: Kalau mau langsung ada link bayar)
                // Kalau gagal, user bisa generate ulang lewat tombol di portal/admin
                // Kita coba generate best effort here.
                $txService = new TransactionService();
                $successUrl = route('landing.payment.show', ['invoice_code' => $invoiceCode, 'status' => 'success']);
                $failureUrl = route('student.portal.index', ['token' => $student->access_token]);
                
                // Gunakan try catch agar kalau Xendit error, Bill lokal tetap kebuat (biar record gak hilang)
                // Atau mau strict: Gagal Xendit = Gagal Bill? -> Lebih aman Best Effort, nanti user bisa retry payment.
                
                try {
                   $result = $txService->createInvoice($transaction, $student, $bill->title, $successUrl, $failureUrl);
                   if ($result['success']) {
                       $bill->update(['transaction_id' => $transaction->id]);
                       // Transaction payment_url is updated inside createInvoice via observer/model update usually?
                       // Service createInvoice biasanya return redirect_url tapi tidak save ke DB transaction payment_url kecuali service nya update.
                       // Cek TransactionService... (kita assume service update model)
                       // update manual just in case
                       $transaction->update(['payment_url' => $result['redirect_url']]);
                   } else {
                       Log::error("Recurring Bill Xendit Failed: " . $result['message']);
                   }
                } catch (\Exception $ex) {
                    Log::error("Recurring Bill Xendit Exception: " . $ex->getMessage());
                }

                // 4. Send WhatsApp Notification
                if ($student->parent_phone) {
                    $portalLink = $student->portal_link;
                    $amountRp = number_format($amount, 0, ',', '.');
                    $msg = "Tagihan Baru Tersedia\n\n"
                         . "Halo Orang Tua {$student->name}, tagihan baru untuk periode {$student->next_billing_date->format('d M Y')} telah terbit.\n"
                         . "Jumlah: Rp{$amountRp}\n"
                         //. "Link Bayar: {$transaction->payment_url}\n" // Bisa kasih direct link
                         . "Silakan cek dan bayar melalui portal siswa:\n"
                         . "{$portalLink}\n\n"
                         . "Terima kasih.";
                    
                    try {
                        $result = $waService->sendMessage($student->parent_phone, $msg);
                        if (!$result) {
                             Log::error("WA Recurring Failed for {$student->name} (Service returned false)");
                        }
                    } catch (\Exception $e) {
                         Log::error("WA Recurring Failed: " . $e->getMessage());
                    }
                }

                // NOTE: Kita TIDAK update next_billing_date disini.
                // next_billing_date hanya maju kalau SUDAH DIBAYAR (di StudentService::processPaymentSuccess)
                // Jadi besok kalau run command ini lagi, karena next_billing_date masih <= today,
                // dia akan ketemu lagi student ini.
                // MAKA DARI ITU KITA BUTUH CEK existingBill DI ATAS BIAR GAK DUPLIKAT.
                
                DB::commit();
                $this->info("Generated bill for {$student->name}");

            } catch (\Exception $e) {
                DB::rollBack();
                $this->error("Error creating bill for {$student->name}: " . $e->getMessage());
            }
        }

        return 0;
    }
}
