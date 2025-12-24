<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

echo "Starting Repair...\n";

// 1. Fix Students with missing branch_id
// They should inherit branch_id from their package
$brokenStudents = Student::whereNull('branch_id')->whereNotNull('package_id')->get();
echo "Found " . $brokenStudents->count() . " students without branch_id.\n";

foreach ($brokenStudents as $student) {
    if ($student->package) {
        $student->update(['branch_id' => $student->package->branch_id]);
        echo "Fixed Student: {$student->name} -> Branch ID: {$student->package->branch_id}\n";
    }
}

// 2. Fix Transactions with missing branch_id
// They should inherit branch_id from their student
$brokenTransactions = Transaction::whereNull('branch_id')->get();
echo "Found " . $brokenTransactions->count() . " transactions without branch_id.\n";

foreach ($brokenTransactions as $trx) {
    // Reload student relationship
    $student = Student::find($trx->student_id);
    if ($student && $student->branch_id) {
        $trx->update(['branch_id' => $student->branch_id]);
        echo "Fixed Transaction ID: {$trx->id} -> Branch ID: {$student->branch_id}\n";
    }
}

echo "Repair Complete.\n";
