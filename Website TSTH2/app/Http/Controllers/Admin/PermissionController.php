<?php

namespace App\Http\Controllers\;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Tambahkan ini!
use App\Models\UserModel;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:superadmin']);
    }

    // Memberikan permission ke user
    public function givePermission(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission' => 'required|exists:permissions,name',
        ]);

        $user = UserModel::findOrFail($request->user_id);
        $user->givePermissionTo($request->permission);

        return response()->json(['message' => 'Permission berhasil diberikan']);
    }

    // Menghapus permission dari user
    public function revokePermission(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission' => 'required|exists:permissions,name',
        ]);

        $user = UserModel::findOrFail($request->user_id);
        $user->revokePermissionTo($request->permission);

        return response()->json(['message' => 'Permission berhasil dicabut']);
    }

    // Melihat permission yang dimiliki user
    public function getUserPermissions($userId)
    {
        $user = UserModel::findOrFail($userId);
        $permissions = $user->permissions()->pluck('name');

        return response()->json(['permissions' => $permissions]);
    }
}
