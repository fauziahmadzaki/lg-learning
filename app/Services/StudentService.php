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
    /**
     * Handle pendaftaran siswa baru beserta logika tagihannya.
     */
    public function registerStudent(array $data, int $packageId): Student
    {
        return DB::transaction(function () use ($data, $packageId) {
            
            // 1. Persiapan Data Awal
            $package = Package::findOrFail($packageId);
            $joinDate = Carbon::parse($data['join_date']);
            $today = Carbon::now();
            
            // Generate Token
            $data['access_token'] = Str::random(32);

            // 2. Hitung Nominal Tagihan per Siklus
            $billAmount = match($data['billing_cycle']) {
                'weekly'  => $package->price / 4,
                'monthly' => $package->price,
                'full'    => $package->price,
                default   => 0,
            };

            // 3. Logika Penentuan Tanggal Tagihan (Next Bill Date)
            $nextBillDate = null;
            $shouldCreateInitialBill = false;

            // --- SKENARIO A: SISWA BARU (PENDING) ---
            if ($data['status'] === 'pending') {
                $shouldCreateInitialBill = true; // Tandai untuk buat bill nanti

                // Next Bill Date = Maju 1 siklus dari SEKARANG
                if ($data['billing_cycle'] == 'weekly') {
                    $nextBillDate = $joinDate->copy()->addWeek();
                } elseif ($data['billing_cycle'] == 'monthly') {
                    $nextBillDate = $joinDate->copy()->addMonth();
                }
            } 
            // --- SKENARIO B: SISWA LAMA (ACTIVE) ---
            else {
                // Loop tanggal dari masa lalu sampai melewati hari ini
                $nextBillDate = $joinDate->copy();
                
                if ($data['billing_cycle'] == 'weekly') {
                    while ($nextBillDate->isPast()) { // Selama masih tanggal lampau
                        $nextBillDate->addWeek();     // Tambah terus
                    }
                } elseif ($data['billing_cycle'] == 'monthly') {
                    while ($nextBillDate->isPast()) {
                        $nextBillDate->addMonth();
                    }
                }
            }

            // Masukkan hasil perhitungan tanggal ke array data
            $data['next_bill_date'] = $nextBillDate;

            // 4. Simpan Siswa ke Database
            $student = Student::create($data);

            // 5. Attach Paket (Relasi Many-to-Many)
            $student->packages()->attach($packageId);

            // 6. Eksekusi Pembuatan Tagihan Awal (Jika Perlu)
            if ($shouldCreateInitialBill) {
                Bill::create([
                    'student_id' => $student->id,
                    'title'      => 'Tagihan Pendaftaran - ' . $package->name,
                    'amount'     => $billAmount,
                    'due_date'   => $today, // Harus bayar sekarang
                    'status'     => 'UNPAID',
                ]);
            }

            return $student;
        });
    }
}