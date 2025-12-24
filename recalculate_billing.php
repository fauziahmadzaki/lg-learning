<?php

use App\Models\Student;
use App\Models\Bill;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting Billing Recalculation for PENDING Students...\n";

// 1. Helper Functions (Copied/Adapted from BillingService)
function calculateAmount($student, $package)
{
    $isDailyRate = $package->duration < 30;

    if ($student->billing_cycle === 'weekly') {
        return $isDailyRate ? ($package->price * 7) : ceil($package->price / 4);
    } elseif ($student->billing_cycle === 'daily') {
        return $isDailyRate ? $package->price : ceil($package->price / 30);
    } elseif ($student->billing_cycle === 'monthly') {
        return $isDailyRate ? ($package->price * 30) : $package->price;
    } elseif ($student->billing_cycle === 'full') {
        if ($isDailyRate) {
            return $package->price * $package->duration;
        } else {
            $months = ceil($package->duration / 30);
            return $package->price * ($months > 0 ? $months : 1);
        }
    }
    return $package->price;
}

function advanceNextBillingDate($student, $package, $currentDueDate)
{
    $nextDate = $currentDueDate->copy();
    if ($student->billing_cycle === 'weekly') {
        $nextDate->addWeek();
    } elseif ($student->billing_cycle === 'daily') {
        $nextDate->addDay();
    } elseif ($student->billing_cycle === 'monthly') {
        $nextDate->addMonth();
    } elseif ($student->billing_cycle === 'full') {
        $nextDate->addMonths(ceil($package->duration / 30));
    }
    return $nextDate;
}

// 2. Fetch Pending Students
$students = Student::where('status', 'pending')->with('package')->get();
echo "Found " . $students->count() . " pending students.\n";

foreach ($students as $student) {
    if (!$student->package) {
        echo "Skipping Student {$student->name} (No Package)\n";
        continue;
    }

    echo "Processing {$student->name} ({$student->join_date})...\n";

    DB::transaction(function () use ($student) {
        // 3. Delete Old Data
        $student->bills()->delete();
        $student->transactions()->delete();

        // 4. Retroactive Bill Generation
        $currentDate = Carbon::parse($student->join_date);
        $now = now();
        $package = $student->package;
        $amount = calculateAmount($student, $package);

        // Safety break to prevent infinite loops if dates don't advance
        $iterations = 0;
        $maxIterations = 100;

        while ($currentDate->lte($now) && $iterations < $maxIterations) {
            // Create Transaction (Paid)
            $transaction = $student->transactions()->create([
                'branch_id'    => $student->branch_id,
                'invoice_code' => 'INV-MIG-' . time() . '-' . $student->id . '-' . $iterations,
                'total_amount' => $amount,
                'status'       => 'PAID',
                'payment_url'  => '#',
                'transaction_date' => $currentDate,
                'paid_at'      => $currentDate,
                'payment_method' => 'MIGRATION',
                'payment_channel' => 'SYSTEM'
            ]);

            // Create Bill (Paid)
            $student->bills()->create([
                'branch_id' => $student->branch_id,
                'title'    => "Tagihan Migrasi " . $package->name . " - " . $currentDate->format('d M Y'),
                'amount'   => $amount,
                'due_date' => $currentDate,
                'status'   => 'PAID',
                'transaction_id' => $transaction->id
            ]);

            // Advance Date
            $currentDate = advanceNextBillingDate($student, $package, $currentDueDate = $currentDate);
            $iterations++;
        }

        // 5. Update Student Status
        $student->update([
            'status' => 'active',
            'next_billing_date' => $currentDate
        ]);
        
        echo "  - Generated $iterations bills.\n";
        echo "  - Next Billing: " . $currentDate->format('Y-m-d') . "\n";
    });
}

echo "Recalculation Complete!\n";
