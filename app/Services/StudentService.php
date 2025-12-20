<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Bill;
use App\Models\Package;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StudentService
{
    public function registerStudent(array $data, int $packageId): Student
    {
        return DB::transaction(function () use ($data, $packageId) {
            $package = Package::findOrFail($packageId);
            $joinDate = Carbon::parse($data['join_date']);
            $today = Carbon::now();
            
            $data['access_token'] = Str::random(32);
            $data['package_id'] = $packageId;
            
            // 1. Create Student
            $student = Student::create($data);

            // 2. Logic Tagihan
            $amount = match($data['billing_cycle']) {
                'weekly'  => $package->price / 4,
                'monthly' => $package->price,
                'full'    => $package->price, // Perlu dikali durasi? User bilang "Full" = Lunas Langsung 
                default   => 0,
            };

            if ($data['billing_cycle'] == 'full') {
                 // Hitung bulan:
                 $months = ceil($package->duration / 30);
                 $amount = $package->price * ($months > 0 ? $months : 1);
            }

            // A. KASUS PENDING (Buat 1 Tagihan + Invoice Xendit)
            if ($data['status'] === 'pending') {
                $dueDate = $joinDate->copy();
                
                // Set Next Billing Date to First Billing Date (Join Date)
                // Logic processPaymentSuccess will advance it to next cycle upon payment.
                $student->update(['next_billing_date' => $dueDate]);

                // Buat Bill
                $bill = Bill::create([
                    'student_id' => $student->id,
                    'branch_id' => $package->branch_id,
                    'title'      => 'Tagihan Pendaftaran - ' . $package->name,
                    'amount'     => $amount,
                    'due_date'   => $today, // Harus bayar sekarang
                    'status'     => 'UNPAID',
                ]);

                // Generate Xendit Invoice
                $invoiceCode = 'INV-' . time() . '-' . $student->id . '-REG';
                $transaction = $student->transactions()->create([
                    'invoice_code' => $invoiceCode,
                    'total_amount' => $amount,
                    'status'       => 'PENDING',
                    'payment_url'  => '#',
                    'transaction_date' => now(),
                ]);

                // Call Service
                $txService = new TransactionService();
                $successUrl = route('landing.payment.show', ['invoice_code' => $invoiceCode, 'status' => 'success']);
                $failureUrl = route('student.portal.index', ['token' => $student->access_token]);
                
                $result = $txService->createInvoice($transaction, $student, "Pendaftaran ".$package->name, $successUrl, $failureUrl);
                
                if ($result['success']) {
                    $bill->update(['transaction_id' => $transaction->id]);
                }
            } 
            
            // B. KASUS ACTIVE (Backdated Logic - Loop dari Join Date sampai Hari Ini)
            elseif ($data['status'] === 'active') {
                $currentDate = $joinDate->copy();
                
                // Loop: Selama tanggal tagihan < hari ini, itu dianggap SUDAH BAYAR (Backdated)
                // Jika join date hari ini, loop minimal 1x jalan.
                // Kita pakai do-while atau while dengan cek logic.
                // Request User: "jika admin memasukkan tanggal daftar lewat dari hari tagihan ... otomatis dibuatkan transaksi ... dan langsung set next billing"
                
                // Logic:
                // 1. Start from Join Date.
                // 2. Transaksi pertama (Join Date) -> PAID.
                // 3. Move to next cycle.
                // 4. If next cycle < today, create another PAID transaction.
                // 5. Repeat until next cycle > today.
                // 6. That future date is 'next_billing_date'.

                do {
                    // Create Bill (PAID)
                    $bill = Bill::create([
                        'student_id' => $student->id,
                        'branch_id' => $package->branch_id,
                        'title'      => 'Tagihan Periode ' . $currentDate->format('d M Y'),
                        'amount'     => $amount,
                        'due_date'   => $currentDate,
                        'status'     => 'PAID',
                    ]);

                    // Create Transaction (PAID - CASH/MANUAL)
                    $invoiceCode = 'INV-AUTO-' . $student->id . '-' . $currentDate->format('dmY');
                    $transaction = $student->transactions()->create([
                        'invoice_code' => $invoiceCode,
                        'total_amount' => $amount,
                        'status'       => 'PAID',
                        'payment_url'  => '#',
                        'transaction_date' => $currentDate, // Tanggal transaksi mundur sesuai status
                        'paid_at'      => $currentDate,
                        'payment_method' => 'CASH',
                        'payment_channel' => 'ADMIN_REG'
                    ]);
                    
                    $bill->update(['transaction_id' => $transaction->id]);

                    // Advance Date
                    if ($data['billing_cycle'] == 'weekly') {
                        $currentDate->addWeek();
                    } elseif ($data['billing_cycle'] == 'monthly') {
                        $currentDate->addMonth();
                    } elseif ($data['billing_cycle'] == 'full') {
                        $currentDate->addDays($package->duration);
                        // Kalau full, biasanya cuma 1x bayar di awal. Jadi break loop setelah 1x.
                        // Kecuali paketnya berulang? Asumsi paket Regular.
                        // Untuk 'full', kita set next billing jauh ke depan dan break.
                    }

                } while ($currentDate->lt($today) && $data['billing_cycle'] !== 'full');


                // Jika Cycle Full, next billing date adalah selesai paket
                if ($data['billing_cycle'] === 'full') {
                     // Next bill date = Join Date + Duration
                     // Tapi karena loop di atas sudah addDays, $currentDate sudah benar.
                }

                $student->update(['next_billing_date' => $currentDate]);
            }

            return $student;
        });
    }

    public function updateStudent(Student $student, array $data, array $packageIds = []): bool
    {
        return DB::transaction(function () use ($student, $data, $packageIds) {
            
            // Handle Package ID change
            if (!empty($packageIds)) {
                // Ambil ID pertama saja karena sekarang logicnya 1 siswa 1 paket
                // $packageIds dikirim sebagai array dari Controller (biar konsisten params), tapi kita ambil yg pertama
                $newPackageId = is_array($packageIds) ? $packageIds[0] : $packageIds;
                $data['package_id'] = $newPackageId;
            }

            $student->update($data);
            
            // TIDAK PERLU SYNC
            // $student->packages()->sync($packageIds);
            
            return true;
        });
    }

    /**
     * Handle logic when a payment is successful (Manual or Xendit).
     * 1. Advance next_billing_date
     * 2. Check if package finished
     * 3. Update status
     */
    public function processPaymentSuccess(Student $student): void
    {
        $package = $student->package;
        if (!$package) return;

        // 1. Advance Next Billing Date
        // Jika null (transaksi pertama), mulai dari join_date atau now()
        $currentDate = $student->next_billing_date ?? $student->join_date ?? now();
        $nextDate = $currentDate->copy();

        if ($student->billing_cycle === 'weekly') {
            $nextDate->addWeek();
        } elseif ($student->billing_cycle === 'monthly') {
            $nextDate->addMonth();
        } elseif ($student->billing_cycle === 'full') {
            $nextDate->addDays($package->duration);
        }

        // 2. Check Finish Condition
        // End Date = Join Date + Duration
        $endDate = null;
        if ($student->join_date) {
            $endDate = $student->join_date->copy()->addDays($package->duration);
        }

        // Status Logic
        $status = 'active';

        // Jika next billing sudah melewati atau sama dengan end date, berarti selesai
        if ($endDate && $nextDate->gte($endDate)) {
            $status = 'finished'; // Selesai
            // Opsional: set next_billing_date ke null atau biarkan sebagai history kapan terakhir lunas
        }

        $student->update([
            'status' => $status,
            'next_billing_date' => $nextDate
        ]);
    }
}