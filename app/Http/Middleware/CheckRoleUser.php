<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AksesModel;

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
        dd(auth()->check(), auth()->user());
        $hasAccess = false;

        if ($type == 'othermenu') {
            $hasAccess = AksesModel::where(['role_id' => $user->role_id, 'othermenu_id' => $menu, 'akses_type' => 'view'])->exists();
        } elseif ($type == 'menu') {
            $hasAccess = AksesModel::leftJoin('tbl_menu', 'tbl_menu.menu_id', '=', 'tbl_akses.menu_id')
                ->where(['tbl_akses.role_id' => $user->role_id, 'tbl_menu.menu_redirect' => $menu, 'tbl_akses.akses_type' => 'view'])
                ->exists();
        } elseif ($type == 'submenu') {
            $hasAccess = AksesModel::leftJoin('tbl_submenu', 'tbl_submenu.submenu_id', '=', 'tbl_akses.submenu_id')
                ->where(['tbl_akses.role_id' => $user->role_id, 'tbl_submenu.submenu_redirect' => $menu, 'tbl_akses.akses_type' => 'view'])
                ->exists();
        }

        if (!$hasAccess) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
