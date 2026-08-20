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
    public function __construct(
        private PackagePricingService $pricing,
        private BillingDateService $billingDate,
    ) {}

    public function searchQuery(array $filters)
    {
        return Student::query()
            ->with(['branch', 'package'])
            ->when($filters['search'] ?? null, fn($q, $v) => $q->where(function($sq) use ($v) {
                $sq->where('name', 'like', "%{$v}%")
                  ->orWhere('school', 'like', "%{$v}%")
                  ->orWhere('email', 'like', "%{$v}%");
            }))
            ->when($filters['branch_id'] ?? null, fn($q, $v) => $q->where('branch_id', $v))
            ->when($filters['grade'] ?? null, fn($q, $v) => $q->where('grade', $v))
            ->when($filters['package_id'] ?? null, fn($q, $v) => $q->where('package_id', $v))
            ->latest();
    }

    public function getFilterData(): array
    {
        return [
            'branches' => \App\Models\Branch::all(),
            'packages' => Package::with('branch')->get(),
            'grades'   => \App\Models\PackageCategory::pluck('name', 'name'),
        ];
    }

    public function registerStudent(array $data, int $packageId): Student
    {
        return DB::transaction(function () use ($data, $packageId) {
            $package = Package::findOrFail($packageId);
            $joinDate = Carbon::parse($data['join_date']);
            $today = Carbon::now();
            
            $data['access_token'] = Str::random(32);
            $data['package_id'] = $packageId;

            // Auto-assign Branch from Package if not provided (Admin Case)
            if (!isset($data['branch_id'])) {
                $data['branch_id'] = $package->branch_id;
            }
            
            // 1. Create Student
            $student = Student::create($data);

            // 2. Logic Tagihan (Disesuaikan dengan Input Harga: Per Hari (<30) atau Per Bulan (>=30))
            $amount = $this->pricing->calculateAmount($package, $data['billing_cycle']);

            // A. KASUS PENDING (Buat 1 Tagihan + Invoice Xendit)
            if ($data['status'] === 'pending') {
                $dueDate = $joinDate->copy();
                
                // Set Next Billing Date to NEXT PERIOD (Month 2) immediately
                // preventing duplicate bill generation for Month 1
                $nextPeriod = $this->billingDate->advanceNextBillingDate($dueDate, $data['billing_cycle'], $package->duration);

                $student->update(['next_billing_date' => $nextPeriod]);

                // Buat Bill
                $bill = Bill::create([
                    'student_id' => $student->id,
                    'branch_id' => $package->branch_id,
                    'title'      => 'Tagihan Pendaftaran - ' . $package->name,
                    'amount'     => $amount,
                    'due_date'   => $dueDate, // Match next_billing_date to prevent duplicates
                    'status'     => 'UNPAID',
                ]);

                // Generate Xendit Invoice
                $invoiceCode = 'INV-' . time() . '-' . $student->id . '-REG';
                $transaction = $student->transactions()->create([
                    'branch_id'    => $package->branch_id,
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

                $endDate = $joinDate->copy()->addDays($package->duration);
                
                // Calculate Max Bills (Match Logic with BillingService)
                // Calculate Max Bills (Match Logic with BillingService)
                $maxBills = 999;
                if ($data['billing_cycle'] === 'daily') {
                    $maxBills = ceil($package->duration);
                } elseif ($data['billing_cycle'] === 'weekly') {
                    $maxBills = ceil($package->duration / 7);
                } elseif ($data['billing_cycle'] === 'monthly') {
                    $maxBills = ceil($package->duration / 30);
                }

                $billCount = 0;

                do {
                    // Check Max Bills Limit
                    if ($billCount >= $maxBills && $data['billing_cycle'] !== 'full') {
                        break;
                    }

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
                        'branch_id'    => $package->branch_id,
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
                    $billCount++;

                    $currentDate = $this->billingDate->advanceNextBillingDate($currentDate, $data['billing_cycle'], $package->duration);

                    // BREAK IF PACKGE FINISHED (Prevent Infinite Loop)
                    if ($currentDate->gte($endDate)) {
                        break;
                    }

                } while ($currentDate->lt($today) && $data['billing_cycle'] !== 'full');


                // Jika Cycle Full, next billing date adalah selesai paket
                if ($data['billing_cycle'] === 'full') {
                     // Next bill date = Join Date + Duration
                     // Tapi karena loop di atas sudah addDays, $currentDate sudah benar.
                }

                // Check if the package is already finished based on the calculated dates
                if ($currentDate->gte($endDate)) {
                    $student->update([
                        'next_billing_date' => $currentDate,
                        'status' => 'inactive'
                    ]);
                } else {
                    $student->update(['next_billing_date' => $currentDate]);
                }
            }


            // --- SEND WHATSAPP NOTIFICATION (REGISTRATION) ---
            try {
                if ($student->parent_phone || $student->name) {
                    $waService = app(\App\Services\WhatsApp\WhatsAppServiceInterface::class);
                    $target = $student->parent_phone;
                    $portalLink = $student->portal_link; // Accessor must exist
                    
                    // Format Message
                    $msg = "";
                    $passwordDefault = $student->phone ?? $student->parent_phone; // Asumsi default password

                    // Schedule Link
                    $scheduleLink = route('schedules.index');

                    if ($data['status'] === 'pending') {
                         $amountRp = number_format($amount, 0, ',', '.');
                         $msg = "🔔 *PENDAFTARAN BERHASIL!* 🔔\n\n"
                              . "Halo Orang Tua *{$student->name}*,\n"
                              . "Terima kasih telah mendaftar di *LG Learning - Cabang {$package->branch->name}*.\n\n"
                              . "📝 *Detail Pendaftaran:*\n"
                              . "👤 Siswa: {$student->name}\n"
                              . "📦 Paket: {$package->name}\n"
                              . "💰 Total Tagihan: Rp {$amountRp}\n\n"
                              . "Silakan selesaikan pembayaran melalui Portal Siswa (Link Otomatis):\n"
                              . "👉 {$portalLink}\n\n"
                              . "ℹ️ *Info:* Portal ini login otomatis (tanpa password), cukup klik link di atas untuk melihat tagihan & jadwal.\n\n"
                              . "Terima kasih telah mempercayakan pendidikan putra-putri Anda bersama kami! 🙏";
                    } else {
                         // Active
                         $msg = "✅ *REGISTRASI BERHASIL & AKTIF!* ✅\n\n"
                              . "Halo Orang Tua *{$student->name}*,\n"
                              . "Selamat bergabung! Putra-putri Anda telah resmi terdaftar di *LG Learning - Cabang {$package->branch->name}*.\n\n"
                              . "📚 *Detail Siswa:*\n"
                              . "👤 Nama: {$student->name}\n"
                              . "📦 Paket: {$package->name}\n"
                              . "✅ Status: *AKTIF*\n\n"
                              . "Anda dapat memantau jadwal belajar dan laporan perkembangan melalui link berikut:\n"
                              . "👉 Portal: {$portalLink}\n"
                              . "📅 Jadwal: {$scheduleLink}\n\n"
                              . "ℹ️ *Info:* Portal ini login otomatis (tanpa password). Simpan link ini untuk akses kapan saja.\n\n"
                              . "Terima kasih! 🙏";
                    }

                    if ($target) {
                        $waService->sendMessage($target, $msg);
                    }
                }
            } catch (\Exception $e) {
                // Log error but don't fail the transaction
                \Illuminate\Support\Facades\Log::error("WA Registration Notification Failed: " . $e->getMessage());
            }

            return $student;
        });
    }

    public function updateStudent(Student $student, array $data, array $packageIds = []): bool
    {
        return DB::transaction(function () use ($student, $data, $packageIds) {
            
            // 1. Handle Package ID change
            if (!empty($packageIds)) {
                $newPackageId = is_array($packageIds) ? $packageIds[0] : $packageIds;
                $data['package_id'] = $newPackageId;
            }

            // Detect Changes
            $oldPackageId = $student->package_id;
            $oldCycle = $student->billing_cycle;
            
            // Update Student Data
            $student->update($data);
            
            // 2. CHECK FOR PENDING BILLS (CORE FEATURE REQUEST)
            // Jika Cycle atau Package berubah, update tagihan yang masih UNPAID.
            if (
                ($data['billing_cycle'] !== $oldCycle) || 
                (isset($data['package_id']) && $data['package_id'] != $oldPackageId)
            ) {
                // Find Pending Bill
                $pendingBill = Bill::where('student_id', $student->id)
                                   ->where('status', 'UNPAID')
                                   ->orderBy('created_at', 'desc') // Ambil yang paling baru
                                   ->first();

                if ($pendingBill) {
                    $package = $student->package; // Sudah updated relation
                    
                    // Recalculate Amount
                    $newAmount = $this->pricing->calculateAmount($package, $student->billing_cycle);
                    
                    // Update Bill
                    $pendingBill->update([
                        'amount' => $newAmount,
                        'title' => 'Tagihan Periode ' . $pendingBill->due_date->format('d M Y') . ' (Updated)',
                    ]);

                    // Update Transaction if exists
                    if ($pendingBill->transaction_id) {
                        $transaction = \App\Models\Transaction::find($pendingBill->transaction_id);
                        if ($transaction && $transaction->status === 'PENDING') {
                            
                            // Update Amount
                            $transaction->update(['total_amount' => $newAmount]);

                            // RE-GENERATE XENDIT INVOICE (Optional but recommended)
                            // Karena kalau tidak, link lama masih pakai harga lama.
                            // Kita mark link lama jadi '#' biar user generate ulang / otomatis generate baru.
                            
                            $newInvoiceCode = 'INV-UPD-' . time() . '-' . $student->id;
                            $transaction->update([
                                'invoice_code' => $newInvoiceCode,
                                'payment_url' => '#' // Reset URL
                            ]);

                            // Try generate new invoice immediately
                            try {
                                $txService = new TransactionService();
                                $successUrl = route('landing.payment.show', ['invoice_code' => $newInvoiceCode, 'status' => 'success']);
                                $failureUrl = route('student.portal.index', ['token' => $student->access_token]);
                                
                                $result = $txService->createInvoice($transaction, $student, $pendingBill->title, $successUrl, $failureUrl);
                                
                                if ($result['success']) {
                                    // Sudah otomatis save payment_url di service
                                    \Illuminate\Support\Facades\Log::info("Updated Invoice for Student {$student->id} to Rp {$newAmount}");
                                }
                            } catch (\Exception $e) {
                                \Illuminate\Support\Facades\Log::error("Failed to regenerate Xendit Invoice on Update: " . $e->getMessage());
                            }
                        }
                    }
                }
            }
            
            return true;
        });
    }

    public function getPortalData(string $token): Student
    {
        return Student::where('access_token', $token)
            ->with(['bills' => fn($q) => $q->latest(), 'transactions' => fn($q) => $q->latest(), 'learningResults', 'package', 'branch'])
            ->firstOrFail();
    }

    public function calculateAmount(Package $package, string $cycle): float
    {
        return $this->pricing->calculateAmount($package, $cycle);
    }

    /**
     * Check if a student's package period is potentially over.
     */
    public function isPeriodOver(Student $student): bool
    {
        if (!$student->package || !$student->join_date) {
            return false;
        }

        if ($student->status === 'finished') {
            return true;
        }

        if (is_null($student->next_billing_date) && $student->status !== 'pending') {
            return true;
        }

        $endDate = $this->billingDate->getEndDate($student->join_date, $student->package);

        if (!$student->next_billing_date) {
            return false;
        }

        return $this->billingDate->isPeriodOver($student->next_billing_date, $endDate, $student->billing_cycle);
    }
}
