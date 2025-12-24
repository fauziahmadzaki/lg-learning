<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\Bill;
use Carbon\Carbon;

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== STARTING FULL MIGRATION V2 ===\n";

// 1. Wipe and Import
echo "[1/5] Wiping Database & Importing lama.sql...\n";
Artisan::call('db:wipe', ['--force' => true]);

$sqlPath = public_path('lama.sql');
if (!file_exists($sqlPath)) $sqlPath = __DIR__ . '/public/lama.sql';

DB::unprepared(file_get_contents($sqlPath));
echo "-> Data imported.\n";

// 2. Truncate Financials (As requested: "hapus transaksi")
echo "[2/5] Deleting OLD Transactions & Bills...\n";
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
Transaction::truncate();
Bill::truncate();
DB::statement('SET FOREIGN_KEY_CHECKS=1;');
echo "-> Financial tables truncated.\n";

// 3. Run Migrations (To update schema structure like branch_id, daily enum, etc)
echo "[3/5] Running Migrations...\n";
Artisan::call('migrate', ['--force' => true]);
echo "-> Schema updated.\n";

// 4. Repair Branch IDs (Backfill from Package)
echo "[4/5] Repairing Branch IDs...\n";
$students = Student::with('package')->get();
foreach ($students as $student) {
    if ($student->package && !$student->branch_id) {
        $student->branch_id = $student->package->branch_id;
        $student->save();
    }
}
echo "-> Branches repaired.\n";

// 5. Recalculate Finances
echo "[5/5] Recalculating Finance History...\n";

function calculateAmountV2($student, $package) {
    $isDailyRate = $package->duration < 30; // Assuming daily if duration is short, consistent with previous logic
    // Logic copies BillingService roughly
    if ($student->billing_cycle === 'weekly') {
        return $isDailyRate ? ($package->price * 7) : ceil($package->price / 4);
    } elseif ($student->billing_cycle === 'daily') {
        return $isDailyRate ? $package->price : ceil($package->price / 30);
    } elseif ($student->billing_cycle === 'monthly') {
        return $isDailyRate ? ($package->price * 30) : $package->price;
    } 
    return $package->price; // Default/Full
}

function advanceDateV2($student, $package, $date) {
    if ($student->billing_cycle === 'weekly') $date->addWeek();
    elseif ($student->billing_cycle === 'daily') $date->addDay();
    elseif ($student->billing_cycle === 'monthly') $date->addMonth();
    elseif ($student->billing_cycle === 'full') $date->addMonths(ceil($package->duration / 30));
    else $date->addMonth(); // Fallback
    return $date;
}

$count = 0;
foreach ($students as $student) {
    if (!$student->package) continue;

    $joinDate = Carbon::parse($student->join_date);
    $now = now();
    $currentDate = $joinDate->copy();
    $amount = calculateAmountV2($student, $student->package);
    
    // Calculate Max Bills based on Duration
    $maxBills = 999;
    if ($student->package->duration > 0) {
        if ($student->billing_cycle === 'monthly') {
            $maxBills = round($student->package->duration / 30);
        } elseif ($student->billing_cycle === 'weekly') {
            $maxBills = round($student->package->duration / 7);
        } elseif ($student->billing_cycle === 'daily') {
            $maxBills = round($student->package->duration);
        }
    }

    // Loop from join date until today OR until max bills reached
    $iteration = 0;
    $isFinished = false;

    while ($currentDate->lte($now) && $iteration < 100) {
        // Stop if we hit the max bills for this package
        if ($iteration >= $maxBills) {
            $isFinished = true;
            break;
        }
        
        $trx = Transaction::create([
            'invoice_code' => 'INV-AUTO-' . $student->id . '-' . $currentDate->format('dmY'),
            'student_id'   => $student->id,
            'branch_id'    => $student->branch_id,
            'total_amount' => $amount,
            'status'       => 'PAID',
            'payment_url'  => '#',
            'payment_method' => 'CASH',
            'payment_channel' => 'ADMIN_REG',
            'paid_at'      => $currentDate,
            'transaction_date' => $currentDate,
        ]);

        Bill::create([
            'student_id' => $student->id,
            'branch_id'  => $student->branch_id,
            'title'      => 'Tagihan Periode ' . $currentDate->format('d M Y'),
            'amount'     => $amount,
            'due_date'   => $currentDate,
            'status'     => 'PAID',
            'transaction_id' => $trx->id
        ]);

        advanceDateV2($student, $student->package, $currentDate);
        $iteration++;
    }

    // Set Final Status logic
    // If we stopped because of max bills AND the last billing date is in the past, they are inactive.
    // However, if we stopped because we reached 'now' (and still have quota), they are active.
    
    if ($isFinished || ($iteration >= $maxBills)) {
         $student->status = 'inactive';
    } else {
         $student->status = 'active';
    }

    // Final Status is already set above
    $student->next_billing_date = $currentDate; // The next future date
    $student->save();
    $count++;
}

echo "-> Processed $count students.\n";
echo "=== COMPLETED ===\n";
