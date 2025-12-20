<?php

namespace App\Services\WhatsApp;

use Illuminate\Support\Facades\Log;

class LogWhatsAppService implements WhatsAppServiceInterface
{
    public function sendMessage(string $target, string $message)
    {
        Log::info("================ WHATSAPP SIMULATION ================");
        Log::info("TO      : " . $target);
        Log::info("MESSAGE : " . $message);
        Log::info("=====================================================");

        return true;
    }
}
