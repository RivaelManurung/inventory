<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckRoleUser
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $menu)
    {
        $user = Auth::user(); // Ambil user yang sedang login

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Ambil role_id dari user
        $roleId = $user->role_id; // Sesuaikan dengan field yang ada di tabel users

        // Cek akses dari tbl_akses
        $hasAccess = DB::table('tbl_akses')
            ->where('role_id', $roleId)
            ->where('menu_id', $menu)
            ->where('akses_type', 1)
            ->exists();

        // Jika tidak memiliki akses, return Forbidden
        if (!$hasAccess) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
