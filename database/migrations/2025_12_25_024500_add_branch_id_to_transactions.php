<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('transactions', 'branch_id')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->foreignId('branch_id')->nullable()->after('student_id')->constrained()->nullOnDelete();
            });
        }

        // Backfill Logic
        $transactions = DB::table('transactions')->get();
        foreach ($transactions as $trx) {
            $student = DB::table('students')->find($trx->student_id);
            if ($student && $student->branch_id) {
                DB::table('transactions')
                    ->where('id', $trx->id)
                    ->update(['branch_id' => $student->branch_id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
};
