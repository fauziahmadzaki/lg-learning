<?php
$student = \App\Models\Student::with(['package', 'transactions'])->latest()->first();
if ($student) {
    echo "ID: " . $student->id . "\n";
    echo "Status: " . $student->status . "\n";
    echo "Join: " . ($student->join_date ? $student->join_date->format('Y-m-d') : 'NULL') . "\n";
    echo "Next Bill: " . ($student->next_billing_date ? $student->next_billing_date->format('Y-m-d') : 'NULL') . "\n";
    echo "Package Duration: " . ($student->package ? $student->package->duration : 'NULL') . "\n";
    echo "Transactions: " . $student->transactions->count() . "\n";
    foreach ($student->transactions as $tx) {
        echo " - " . $tx->invoice_code . " | " . $tx->status . " | " . ($tx->paid_at ? $tx->paid_at->format('Y-m-d H:i') : 'Unpaid') . "\n";
    }
} else {
    echo "No student found.\n";
}
