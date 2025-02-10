<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AksesModel;
use Illuminate\Support\Facades\DB;

class CheckRoleUser
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $menu, $type)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Debugging menu dan type sebelum query
        // dd(compact('menu', 'type'));

        // Pastikan menu bertipe integer jika berisi ID
        $menu = is_numeric($menu) ? (int) $menu : $menu;

        if ($type == 'othermenu') {
            $hasAccess = DB::table('tbl_akses')
            ->where('role_id', 1)
            ->where('othermenu_id', 1)
            ->where('akses_type', 'view')
            ->exists();
        
        // dd($hasAccess);
        
        } elseif ($type == 'menu') {
            $hasAccess = AksesModel::leftJoin('tbl_menu', 'tbl_menu.menu_id', '=', 'tbl_akses.menu_id')
                ->where([
                    'tbl_akses.role_id' => $user->role_id,
                    'tbl_menu.menu_redirect' => $menu,
                    'tbl_akses.akses_type' => 'view'
                ])
                ->exists();
        } elseif ($type == 'submenu') {
            $hasAccess = AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')
                ->where([
                    'tbl_akses.role_id' => $user->role_id,
                    'tbl_submenu.submenu_redirect' => $menu,
                    'tbl_akses.akses_type' => 'view'
                ])
                ->exists();
        } else {
            $hasAccess = false;
        }

        // Debugging hasil query
        // dd(compact('menu', 'type', 'hasAccess'));

        if (!$hasAccess) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
