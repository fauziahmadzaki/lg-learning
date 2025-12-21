<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */

    public function register(): void
    {
        // Bind WhatsApp Service
        $this->app->bind(\App\Services\WhatsApp\WhatsAppServiceInterface::class, function ($app) {
            $gateway = env('WHATSAPP_GATEWAY', 'log');

            if ($gateway === 'fonnte') {
                return new \App\Services\WhatsApp\FonnteWhatsAppService();
            }

            return new \App\Services\WhatsApp\LogWhatsAppService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::resourceVerbs([
            'create' => 'tambah',
        ]);


    }
}
