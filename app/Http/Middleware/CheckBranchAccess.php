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

        if(!$user){
            return redirect()->route('login');
        }

        $branchRoute = $request->route('branches');

        $branchId = $branchRoute instanceof Branch? $branchRoute->id : $branchRoute;
            
        // Check is Admin
        if(is_null($user->branch_id)){
            return $next($request);
        }

        if($user->branch_id != $branchId){
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
