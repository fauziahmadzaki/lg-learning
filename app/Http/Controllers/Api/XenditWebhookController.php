<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class XenditWebhookController extends Controller
{
    public function handle(Request $request)
    {
        
        $xenditXCallbackToken = env('XENDIT_CALLBACK_TOKEN');
        $reqHeaders = $request->header('x-callback-token');

        if ($xenditXCallbackToken && $reqHeaders !== $xenditXCallbackToken) {
            return response()->json(['message' => 'Invalid Token'], 403);
        }

        // 2. Ambil Data dari Xendit
        $data = $request->all();
        
        // Pastikan ini notifikasi invoice yang sudah dibayar ('PAID')
        if (!isset($data['status']) || $data['status'] !== 'PAID') {
            return response()->json(['message' => 'Status not PAID, ignored'], 200);
        }

        // 3. Cari Transaksi di Database
        $transaction = Transaction::where('invoice_code', $data['external_id'])->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Jika transaksi sudah PAID sebelumnya, abaikan (biar ga double process)
        if ($transaction->status === 'PAID') {
            return response()->json(['message' => 'Already paid'], 200);
        }

        // 4. Update Database (Pakai DB Transaction biar aman)
        DB::beginTransaction();
        try {
            // A. Update Transaksi jadi PAID
            $transaction->update([
                'status'         => 'PAID',
                'payment_method' => $data['payment_method'] ?? null,
                'payment_channel'=> $data['payment_channel'] ?? null,
                'paid_at'        => parse_xendit_date($data['paid_at']), // Perlu helper parsing tanggal
            ]);

            // B. Update Status Siswa jadi ACTIVE
            // Karena sudah bayar, siswa resmi aktif
            $student = Student::find($transaction->student_id);
            if ($student) {
                $student->update(['status' => 'active']);
            }

            DB::commit();
            return response()->json(['message' => 'Payment success processed'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error processing: ' . $e->getMessage()], 500);
        }
    }
}

// Helper function kecil untuk format tanggal Xendit (ISO 8601) ke MySQL
function parse_xendit_date($dateString) {
    return \Carbon\Carbon::parse($dateString)->format('Y-m-d H:i:s');
}