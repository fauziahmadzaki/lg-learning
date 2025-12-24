<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$transactions = \App\Models\Transaction::latest()->take(5)->get();
echo "Total Recent Transactions: " . $transactions->count() . "\n";
foreach ($transactions as $trx) {
    echo "--------------------------------------------------\n";
    echo "ID: " . $trx->id . "\n";
    echo "Invoice: " . $trx->invoice_code . "\n";
    echo "Status: " . $trx->status . "\n";
    echo "Type: " . ($trx->type ?? 'NULL') . "\n";
    echo "Total Amount: " . $trx->total_amount . "\n";
    echo "Paid At: " . ($trx->paid_at ? $trx->paid_at->format('Y-m-d H:i:s') : 'NULL') . "\n";
    echo "Transaction Date: " . ($trx->transaction_date ? $trx->transaction_date->format('Y-m-d H:i:s') : 'NULL') . "\n";
    echo "Branch ID: " . ($trx->branch_id ?? 'NULL') . "\n";
    echo "Student Name: " . ($trx->student ? $trx->student->name : 'No Student') . "\n";
    echo "Student Branch: " . ($trx->student ? ($trx->student->branch ? $trx->student->branch->name : 'No Branch') : '-') . "\n";
}
