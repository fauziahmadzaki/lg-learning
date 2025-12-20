<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Bill;
use App\Models\Student;
use App\Services\WhatsApp\WhatsAppServiceInterface;
use Illuminate\Support\Facades\Log;

class CheckDueBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bills:check-due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for unpaid bills due today and send WhatsApp reminders';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppServiceInterface $waService)
    {
        $today = now()->format('Y-m-d');
        $this->info("Checking bills due on: $today");

        // Cari Tagihan Belum Lunas & Jatuh Tempo Hari Ini (atau lewat)
        // Kita batasi hanya yang due_date = today agar tidak spamming setiap hari jika telat
        // Atau bisa pakai logic last_reminder_sent_at jika mau reminder ulang.
        // Versi simpel: Reminder pas hari H.
        
        $bills = Bill::whereDate('due_date', $today)
                     ->where('status', '!=', 'PAID')
                     ->with('student')
                     ->get();

        $count = $bills->count();
        $this->info("Found $count bills due today.");

        foreach ($bills as $bill) {
            $student = $bill->student;
            if (!$student) continue;

            $target = $student->parent_phone;
            if (!$target) {
                $this->warn("Skipping Bill ID {$bill->id}: No parent phone for student {$student->name}");
                continue;
            }

            $portalLink = $student->portal_link;
            $amountRp = number_format($bill->amount, 0, ',', '.');
            
            $message = "Halo Orang Tua {$student->name},\n\n"
                     . "Mengingatkan bahwa tagihan '{$bill->title}' sebesar Rp{$amountRp} jatuh tempo hari ini ({$today}).\n\n"
                     . "Mohon segera melakukan pembayaran melalui portal siswa:\n"
                     . "{$portalLink}\n\n"
                     . "Terima kasih.";

            try {
                $result = $waService->sendMessage($target, $message); // Returns array or false
                
                if ($result) {
                    $this->info("Sent reminder to {$student->name} ($target)");
                } else {
                    $this->error("Failed to send to {$student->name} (Check logs for details)");
                }
            } catch (\Exception $e) {
                Log::error("Failed to send bill due reminder: " . $e->getMessage());
                $this->error("Exception sending to {$student->name}");
            }
        }

        return 0;
    }
}
