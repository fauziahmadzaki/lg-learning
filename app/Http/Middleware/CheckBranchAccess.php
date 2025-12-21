<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBranchAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 1. Pastikan user login
        if (!$user) {
            return redirect()->route('login');
        }

        // 2. Ambil parameter 'branch' dari URL (sesuai perubahan di web.php)
        // Parameter ini bisa berupa ID (string/int) atau Object Branch (jika route model binding aktif)
        $branchRoute = $request->route('branch');

        // Jika user mengakses route yang tidak ada parameter branch-nya, loloskan saja (atau handle error)
        if (!$branchRoute) {
            return $next($request);
        }

        // 3. Ekstrak ID Cabang
        $requestedBranchId = $branchRoute instanceof Branch ? $branchRoute->id : $branchRoute;

        // 4. Logika Pengecekan
        
        // Jika User adalah Central Admin (branch_id null), Izinkan akses ke mana saja
        if (is_null($user->branch_id)) {
            return $next($request);
        }

        // Jika User adalah Staff Cabang, pastikan ID cabang di URL sama dengan ID cabang user
        if ($user->branch_id != $requestedBranchId) {
            abort(403, 'Anda tidak memiliki akses ke cabang ini.');
        }

        return $next($request);
    }
}