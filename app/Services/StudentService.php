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

            // Auto-assign Branch from Package if not provided (Admin Case)
            if (!isset($data['branch_id'])) {
                $data['branch_id'] = $package->branch_id;
            }
            
            // 1. Create Student
            $student = Student::create($data);

            // 2. Logic Tagihan (Disesuaikan dengan Input Harga: Per Hari (<30) atau Per Bulan (>=30))
            $amount = $this->calculateAmount($package, $data['billing_cycle']);

            // A. KASUS PENDING (Buat 1 Tagihan + Invoice Xendit)
            if ($data['status'] === 'pending') {
                $dueDate = $joinDate->copy();
                
                // Set Next Billing Date to NEXT PERIOD (Month 2) immediately
                // preventing duplicate bill generation for Month 1
                $nextPeriod = $dueDate->copy();
                if ($data['billing_cycle'] == 'daily') {
                    $nextPeriod->addDay();
                } elseif ($data['billing_cycle'] == 'weekly') {
                    $nextPeriod->addWeek();
                } elseif ($data['billing_cycle'] == 'monthly') {
                    $nextPeriod->addMonth();
                } elseif ($data['billing_cycle'] == 'full') {
                    $nextPeriod->addDays($package->duration);
                }

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

                    // Advance Date
                    if ($data['billing_cycle'] == 'daily') {
                        $currentDate->addDay();
                    } elseif ($data['billing_cycle'] == 'weekly') {
                        $currentDate->addWeek();
                    } elseif ($data['billing_cycle'] == 'monthly') {
                        $currentDate->addMonth();
                    } elseif ($data['billing_cycle'] == 'full') {
                        $currentDate->addDays($package->duration);
                    }

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
                    $newAmount = $this->calculateAmount($package, $student->billing_cycle);
                    
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

    /**
     * Helper to calculate billing amount based on package and cycle.
     */
    public function calculateAmount(Package $package, string $cycle): float
    {
        $isDailyRate = $package->duration < 30;
        
        return match($cycle) {
            'daily'   => $isDailyRate ? $package->price : ceil($package->price / 30),
            'weekly'  => $isDailyRate ? ($package->price * 7) : ceil($package->price / 4),
            'monthly' => $isDailyRate ? ($package->price * 30) : $package->price,
            'full'    => $isDailyRate ? ($package->price * $package->duration) : ($package->price * ceil($package->duration / 30)),
            default   => 0,
        };
    }

    /**
     * Handle logic when a payment is successful (Manual or Xendit).
     * 1. Advance next_billing_date
     * 2. Check if package finished
     * 3. Update status
     * 4. Send WhatsApp (Optional)
     */
    public function processPaymentSuccess(Student $student, /* ?Transaction */ $transaction = null, bool $sendNotification = true): void
    {
        $package = $student->package;
        if (!$package) return;

        // Determine Base Date for calculation
        // Default to current next_billing_date logic
        $baseDate = $student->next_billing_date ?? $student->join_date ?? now();

        // IDEMPOTENCY FIX:
        // Try to derive base date from the Bill associated with this Transaction.
        // This ensures that paying "Bill of Jan 20" ALWAYS results in "Next Bill = Feb 20",
        // regardless of how many times this function runs (Race Condition Proof).
        if ($transaction) {
            // Load bills if not loaded
            if (!$transaction->relationLoaded('bills')) {
                $transaction->load('bills');
            }
            
            $bill = $transaction->bills->first();
            if ($bill) {
                // Base date is the bill's due date
                $baseDate = $bill->due_date->copy();
            }
        }

        // Calculate Next Pending Date
        $nextDate = $baseDate->copy();

        // Advance Logic
        if ($student->billing_cycle === 'daily') {
            $nextDate->addDay();
        } elseif ($student->billing_cycle === 'weekly') {
            $nextDate->addWeek();
        } elseif ($student->billing_cycle === 'monthly') {
            $nextDate->addMonth();
        } elseif ($student->billing_cycle === 'full') {
            $nextDate->addDays($package->duration);
        }

        // Logic check for Pending (Registration)
        // If we used Bill Date (Dec 20), Next is Jan 20.
        // If Register logic set next to Jan 20 already.
        // Jan 20 = Jan 20. Update is fine.
        
        // Safety: Only update if nextDate is > current stored date
        // (Prevent reverting if transactions come out of order, though unlikely for sequential bills)
        $currentStoredDate = $student->next_billing_date;
        
        // Special Case: Initial Registration where we Pre-Advanced to Month 2.
        // If paying Dec 20 Bill. Next = Jan 20.
        // Current Stored = Jan 20.
        // Result: Jan 20. No change. Correct.

        $finalNextDate = $nextDate;
        if ($currentStoredDate && $currentStoredDate->gt($nextDate)) {
             $finalNextDate = $currentStoredDate;
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
        if ($endDate && $finalNextDate->gte($endDate)) {
            $status = 'inactive'; // Package finished 
        }

        $student->update([
            'status' => $status,
            'next_billing_date' => $status === 'inactive' ? null : $finalNextDate
        ]);

        // SEND WHATSAPP NOTIFICATION
        if ($sendNotification) {
            try {
                if ($student->parent_phone || $student->name) { 
                    $invoiceUrl = $transaction ? $transaction->payment_url : '-';
                    // If payment url is '#' (manual), maybe use route
                    if ($transaction && $transaction->payment_url == '#') {
                        $invoiceUrl = route('landing.payment.show', ['invoice_code' => $transaction->invoice_code, 'status' => 'success']);
                    }

                    $waService = app(\App\Services\WhatsApp\WhatsAppServiceInterface::class);
                    $target = $student->parent_phone; 
                    
                    $portalLink = $student->portal_link;
                    
                    $scheduleLink = route('schedules.index');

                    $msgPayment = "✅ *PEMBAYARAN DITERIMA!* ✅\n\n"
                        . "Halo Orang Tua *{$student->name}*,\n"
                        . "Pembayaran untuk paket *{$package->name}* periode *{$baseDate->format('d M Y')}* telah berhasil.\n\n"
                        . "✅ Status: *LUNAS*\n"
                        . "🔗 Invoice: {$invoiceUrl}\n\n"
                        . "Bukti pembayaran & jadwal belajar dapat dilihat di Portal Siswa:\n"
                        . "👉 Portal: {$portalLink}\n"
                        . "📅 Jadwal: {$scheduleLink}\n\n"
                        . "Terima kasih! 🙏";

                    if ($target) {
                        $waService->sendMessage($target, $msgPayment);
                    }

                    // 2. Course Finished
                    if ($status === 'inactive') {
                        $msgFinish = "Selamat {$student->name}!\n\n"
                            . "Anda telah menyelesaikan program {$package->name}.\n"
                            . "Terima kasih telah belajar bersama LG Learning.\n"
                            . "Akses sertifikat/raport di portal: {$portalLink}";
                        
                        if ($target) {
                            $waService->sendMessage($target, $msgFinish);
                        }
                    }
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Failed to send WA in Service: " . $e->getMessage());
            }
        }
    }

    /**
     * Check if a student's package period is potentially over.
     */
    public function isPeriodOver(Student $student): bool
    {
        if (!$student->package || !$student->join_date) {
            return false;
        }

        $endDate = $student->join_date->copy();
        
        // Logic Weekly/Monthly
        if ($student->billing_cycle === 'weekly') {
             $weeks = floor($student->package->duration / 7);
             $weeks = ($weeks < 1) ? 1 : $weeks;
             $endDate->addWeeks($weeks);
        } else {
             $endDate->addDays($student->package->duration);
        }

        if ($student->status === 'finished') {
            return true;
        }

        // --- DYNAMIC TOLERANCE LOGIC (Match GenerateRecurringBills) ---
        $cycleDays = match($student->billing_cycle) {
            'monthly' => 30,
            'weekly'  => 7,
            'daily'   => 1,
            default   => 30
        };
        $toleranceDays = ceil($cycleDays * 0.2);
        $cutoffDate = $endDate->copy()->subDays($toleranceDays);

        if ($student->next_billing_date && $student->next_billing_date->greaterThanOrEqualTo($cutoffDate)) {
            return true;
        } elseif (is_null($student->next_billing_date) && $student->status !== 'pending') {
            return true;
        }

        return false;
    }
}
