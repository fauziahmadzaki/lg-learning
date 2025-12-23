<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Xendit Webhook: Start Processing', ['ip' => $request->ip()]);

        $xenditXCallbackToken = env('XENDIT_CALLBACK_TOKEN');
        $reqHeaders = $request->header('x-callback-token');

        Log::info('Xendit Webhook: Token Verification', [
            'env_token_set' => !empty($xenditXCallbackToken),
            'header_token' => $reqHeaders ? 'PRESENT' : 'MISSING',
            'match' => $xenditXCallbackToken === $reqHeaders
        ]);

        if ($xenditXCallbackToken && $reqHeaders !== $xenditXCallbackToken) {
            Log::warning('Xendit Webhook: Invalid Token', ['received' => $reqHeaders]);
            return response()->json(['message' => 'Invalid Token'], 403);
        }

        // 2. Ambil Data dari Xendit
        $data = $request->all();
        Log::info('Xendit Webhook: Payload Received', ['data' => $data]);
        
        // Pastikan ini notifikasi invoice yang sudah dibayar ('PAID')
        if (!isset($data['status']) || $data['status'] !== 'PAID') {
            Log::info('Xendit Webhook: Ignored (Status not PAID)', ['status' => $data['status'] ?? 'NULL']);
            return response()->json(['message' => 'Status not PAID, ignored'], 200);
        }

        // 3. Update Database (Pakai DB Transaction & Lock)
        DB::beginTransaction();
        try {
            // Cari Transaction dengan LOCK untuk mencegah Race Condition
            $transaction = Transaction::where('invoice_code', $data['external_id'])
                                    ->lockForUpdate()
                                    ->first();

            if (!$transaction) {
                 DB::rollBack();
                 Log::error('Xendit Webhook: Transaction not found', ['external_id' => $data['external_id']]);
                 return response()->json(['message' => 'Transaction not found'], 404);
            }

            Log::info('Xendit Webhook: Transaction Found', ['id' => $transaction->id, 'current_status' => $transaction->status]);

            // Jika transaksi sudah PAID sebelumnya, abaikan (biar ga double process)
            if ($transaction->status === 'PAID') {
                DB::rollBack();
                Log::info('Xendit Webhook: Already PAID', ['id' => $transaction->id]);
                return response()->json(['message' => 'Already paid'], 200);
            }

            // A. Update Transaksi jadi PAID
            $transaction->update([
                'status'         => 'PAID',
                'payment_method' => $data['payment_method'] ?? null,
                'payment_channel'=> $data['payment_channel'] ?? null,
                'paid_at'        => parse_xendit_date($data['paid_at']), // Perlu helper parsing tanggal
            ]);

            // B. Update Status Siswa & Next Billing Date (Via Service)
            $student = Student::find($transaction->student_id);
            if ($student) {
                // Dependency Injection manual atau via constructor. Disini manual agar minim perubahan
                $studentService = app(\App\Services\StudentService::class);
                // Pass transaction for idempotency
                $studentService->processPaymentSuccess($student, $transaction);
                Log::info('Xendit Webhook: Student Updated', ['student_id' => $student->id]);
            } else {
                Log::warning('Xendit Webhook: Student not found for transaction', ['student_id' => $transaction->student_id]);
            }

            // C. Update Status Tagihan (Bill) jadi PAID jika ada
            $bill = \App\Models\Bill::where('transaction_id', $transaction->id)->first();
            if ($bill) {
                $bill->update(['status' => 'PAID']);
                Log::info('Xendit Webhook: Related Bill Updated', ['bill_id' => $bill->id]);
            }

            DB::commit();
            Log::info('Xendit Webhook: Success Processing Complete', ['transaction_id' => $transaction->id]);
            return response()->json(['message' => 'Payment success processed'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Xendit Webhook: Exception', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'Error processing: ' . $e->getMessage()], 500);
        }
    }
}

// Helper function kecil untuk format tanggal Xendit (ISO 8601) ke MySQL
function parse_xendit_date($dateString) {
    return \Carbon\Carbon::parse($dateString)->format('Y-m-d H:i:s');
}