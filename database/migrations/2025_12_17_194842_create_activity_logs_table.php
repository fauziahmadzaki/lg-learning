<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Siapa pelakunya
            $table->foreignId('branch_id')->nullable()->constrained()->onDelete('cascade'); // Di cabang mana kejadiannya
            $table->string('action'); // CREATE, UPDATE, atau DELETE
            $table->string('description'); // Penjelasan singkat (Human readable)
            $table->string('subject_type')->nullable(); // Model apa? (Misal: App\Models\Student)
            $table->unsignedBigInteger('subject_id')->nullable(); // ID data yang mana?
            $table->json('properties')->nullable(); // Data sebelum & sesudah (Old vs New)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};