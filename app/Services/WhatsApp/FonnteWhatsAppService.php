<?php

namespace App\Services\WhatsApp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteWhatsAppService implements WhatsAppServiceInterface
{
    protected string $token;

    public function __construct()
    {
        $this->token = env('FONNTE_TOKEN', '');
    }

    public function sendMessage(string $target, string $message)
    {
        if (empty($this->token)) {
            Log::warning("Fonnte Token is missing in .env");
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62', // Default Indonesia
            ]);

            $body = $response->json();

            if ($response->successful() && isset($body['status']) && $body['status'] == true) {
                Log::info("Fonnte Success: " . json_encode($body));
                return $body;
            } else {
                Log::error("Fonnte Failed. HTTP: " . $response->status() . " Body: " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error("Fonnte Exception: " . $e->getMessage());
            return false;
        }
    }
}
