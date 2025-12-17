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

            $billAmount = match($data['billing_cycle']) {
                'weekly'  => $package->price / 4,
                'monthly' => $package->price,
                'full'    => $package->price,
                default   => 0,
            };

            $nextBillDate = null;
            $shouldCreateInitialBill = false;

            if ($data['status'] === 'pending') {
                $shouldCreateInitialBill = true;

                if ($data['billing_cycle'] == 'weekly') {
                    $nextBillDate = $joinDate->copy()->addWeek();
                } elseif ($data['billing_cycle'] == 'monthly') {
                    $nextBillDate = $joinDate->copy()->addMonth();
                }
            } 
            
            else {

                $nextBillDate = $joinDate->copy();
                
                if ($data['billing_cycle'] == 'weekly') {
                    while ($nextBillDate->isPast()) { 
                        $nextBillDate->addWeek();
                    }
                } elseif ($data['billing_cycle'] == 'monthly') {
                    while ($nextBillDate->isPast()) {
                        $nextBillDate->addMonth();
                    }
                }
            }

            $data['next_bill_date'] = $nextBillDate;

            $student = Student::create($data);

            $student->packages()->attach($packageId);

            if ($shouldCreateInitialBill) {
                Bill::create([
                    'student_id' => $student->id,
                    'branch_id' => $package->branch_id,
                    'title'      => 'Tagihan Pendaftaran - ' . $package->name,
                    'amount'     => $billAmount,
                    'due_date'   => $today,
                    'status'     => 'UNPAID',
                ]);
            }

            return $student;
        });
    }
}