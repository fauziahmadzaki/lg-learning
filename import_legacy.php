<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Models\Student;

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting Legacy Data Migration...\n";

// 1. Wipe Database
echo "Wiping database...\n";
Artisan::call('db:wipe', ['--force' => true]);
echo "Database wiped.\n";

// 2. Import SQL
echo "Importing lama.sql...\n";
$sqlPath = public_path('lama.sql');
// Fallback for path if public_path() behaves unexpectedly in CLI without serve context (usually fine)
if (!file_exists($sqlPath)) {
    $sqlPath = __DIR__ . '/public/lama.sql';
}

if (!file_exists($sqlPath)) {
    die("Error: lama.sql not found at $sqlPath\n");
}

try {
    DB::unprepared(file_get_contents($sqlPath));
    echo "SQL Imported successfully.\n";
} catch (\Exception $e) {
    die("Error importing SQL: " . $e->getMessage() . "\n");
}

// 3. Run Migrations
echo "Running pending migrations...\n";
Artisan::call('migrate', ['--force' => true]);
echo Artisan::output();

// 4. Update Student Status
echo "Updating student statuses to 'pending'...\n";
// Ensure we are targeting the right model
try {
    $count = Student::query()->update(['status' => 'pending']);
    echo "Updated $count students to pending status.\n";
} catch (\Exception $e) {
    echo "Error updating students: " . $e->getMessage() . "\n";
}

echo "Migration Complete!\n";
