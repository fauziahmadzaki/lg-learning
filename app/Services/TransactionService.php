<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Student;
use App\Models\Package;
use Illuminate\Support\Str;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
use Exception;

class TransactionService
{
    public function __construct()
    {
        Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));
    }

    /**
     * Create a new transaction and generate Xendit Invoice
     */
    /**
     * Create Xendit Invoice for an existing Transaction
     * 
     * @param Transaction $transaction Local Transaction Model
     * @param Student $student Payer
     * @param string $description Payment Description
     * @param string $successUrl specific redirect URL
     * @param string $failureUrl specific redirect URL
     */
    public function createInvoice(Transaction $transaction, Student $student, string $description, string $successUrl, string $failureUrl)
    {
        // 1. Siapkan Request Xendit
        $createInvoiceRequest = new CreateInvoiceRequest([
            'external_id' => $transaction->invoice_code,
            'amount' => $transaction->total_amount,
            'payer_email' => $student->email,
            'description' => $description,
            'invoice_duration' => 86400, // 24 Jam
            
            'success_redirect_url' => $successUrl,
            'failure_redirect_url' => $failureUrl,
            'currency' => 'IDR',
            'reminder_time' => 1
        ]);

        try {
            // 2. Tembak API Xendit
            $apiInstance = new InvoiceApi();
            $xenditInvoice = $apiInstance->createInvoice($createInvoiceRequest);

            // 3. Simpan Link Pembayaran ke Database
            $transaction->payment_url = $xenditInvoice['invoice_url'];
            $transaction->save();

            return [
                'success' => true,
                'redirect_url' => $xenditInvoice['invoice_url'],
                'transaction' => $transaction
            ];

        } catch (Exception $e) {
            // Log error jika perlu
            // \Illuminate\Support\Facades\Log::error('Xendit Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    /**
     * Get Invoice Status from Xendit
     */
    public function getInvoiceStatus(string $invoiceCode)
    {
        try {
            $apiInstance = new InvoiceApi();
            // Xendit SDK getInvoices filters by array info, but typically getInvoiceById is what we want if we had the XenditID.
            // Since we stored external_id, we search using getInvoices.
            // OR if we stored xendit_id, we use getInvoiceById.
            // We only stored 'invoice_code' as external_id.
            
            $result = $apiInstance->getInvoices(null, $invoiceCode);
            
            if (count($result) > 0) {
                return $result[0];
            }
            
            return null;

        } catch (Exception $e) {
            return null;
        }
    }
}
