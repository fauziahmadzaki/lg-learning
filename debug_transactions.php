<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$transactions = \App\Models\Transaction::latest()->take(5)->get();
foreach ($transactions as $trx) {
    echo "ID: " . $trx->id . " | Branch ID: " . ($trx->branch_id ?? 'NULL') . " | Student ID: " . $trx->student_id . "\n";
}
