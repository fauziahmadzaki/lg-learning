<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('tutor_id')->nullable()->constrained()->onDelete('set null');
            $table->date('session_date');
            $table->unsignedTinyInteger('session_number')->default(1);
            $table->string('topic');
            $table->enum('attendance', ['hadir', 'izin', 'alfa'])->default('hadir');
            $table->unsignedTinyInteger('score')->nullable();
            $table->text('notes')->nullable();
            $table->string('homework')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_results');
    }
};
