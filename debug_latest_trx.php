<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Transaction;

// Load latest 10 transactions
$trxs = Transaction::latest('id')->take(10)->get();

echo "ID | Invoice | Total Amount (Raw) | Total Amount (Casted) | Type | Created At\n";
echo str_repeat("-", 80) . "\n";

foreach ($trxs as $trx) {
    echo "{$trx->id} | {$trx->invoice_code} | " . 
         $trx->getRawOriginal('total_amount') . " | " . 
         $trx->total_amount . " | " . 
         ($trx->type ?? 'N/A') . " | " . 
         $trx->created_at . "\n";
}
