<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        // Saat Data Dibuat (CREATE)
        static::created(function ($model) {
            self::logToDatabase($model, 'CREATE', 'Menambahkan data baru');
        });

        // Saat Data Diedit (UPDATE)
        static::updated(function ($model) {
            // Cek apa saja yang berubah
            $changes = $model->getChanges();
            $original = $model->getOriginal();
            
            // Filter hanya kolom yang berubah (abaikan updated_at)
            $diff = [];
            foreach ($changes as $key => $value) {
                if ($key !== 'updated_at' && $key !== 'created_at') {
                    $diff[$key] = [
                        'from' => $original[$key] ?? null,
                        'to'   => $value,
                    ];
                }
            }

            if (!empty($diff)) {
                self::logToDatabase($model, 'UPDATE', 'Mengubah data', $diff);
            }
        });

        // Saat Data Dihapus (DELETE)
        static::deleted(function ($model) {
            self::logToDatabase($model, 'DELETE', 'Menghapus data');
        });
    }

    protected static function logToDatabase($model, $action, $description, $properties = [])
    {
        // Coba deteksi Branch ID dari model itu sendiri, atau dari User yang login
        $branchId = $model->branch_id ?? (Auth::user()->branch_id ?? null);

        ActivityLog::create([
            'user_id'      => Auth::id(),
            'branch_id'    => $branchId,
            'action'       => $action,
            'description'  => $description . ' di tabel ' . class_basename($model),
            'subject_type' => get_class($model),
            'subject_id'   => $model->id,
            'properties'   => $properties, // Simpan detail perubahan (Old vs New)
        ]);
    }
}