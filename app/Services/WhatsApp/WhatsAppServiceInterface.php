<?php

namespace App\Services\WhatsApp;

interface WhatsAppServiceInterface
{
    /**
     * Send a WhatsApp message to a specific target.
     *
     * @param string $target The phone number (e.g., "08123456789")
     * @param string $message The message content
     * @return mixed Response from the provider
     */
    public function sendMessage(string $target, string $message);
}
