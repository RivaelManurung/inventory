<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Admin\BaseController;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends BaseController
{
    public function index()
    {
        $users = UserModel::with('role')->latest()->get();
        return response()->json(["status" => "success", "data" => $users], 200);
    }

    public function show($id)
    {
        $user = UserModel::with('role')->find($id);
        if (!$user) {
            return response()->json(["status" => "error", "message" => "User not found"], 404);
        }
        return response()->json(["status" => "success", "data" => $user], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_nmlengkap' => 'required',
            'user_nama' => 'required|unique:tbl_user,user_nama',
            'user_email' => 'required|email|unique:tbl_user,user_email',
            'role_id' => 'required|exists:roles,id',
            'user_password' => 'required|min:6',
            'user_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(["status" => "error", "errors" => $validator->errors()], 400);
        }

        $img = "undraw_profile.svg";
        if ($request->hasFile('user_foto')) {
            $img = $request->file('user_foto')->store('users', 'public');
        }

        $user = UserModel::create([
            'user_foto' => $img,
            'user_nmlengkap' => $request->user_nmlengkap,
            'user_nama' => $request->user_nama,
            'user_email' => $request->user_email,
            'role_id' => $request->role_id,
            'user_password' => Hash::make($request->user_password)
        ]);

        $role = Role::findById($request->role_id);
        $user->assignRole($role);

        return response()->json(["status" => "success", "data" => $user], 201);
    }

    public function update(Request $request, $id)
    {
        $user = UserModel::find($id);
        if (!$user) {
            return response()->json(["status" => "error", "message" => "User not found"], 404);
        }

        $data = $request->only(['user_nmlengkap', 'user_nama', 'user_email', 'role_id']);
        if ($request->has('user_password')) {
            $data['user_password'] = Hash::make($request->user_password);
        }
        if ($request->hasFile('user_foto')) {
            if ($user->user_foto && Storage::exists('public/' . $user->user_foto)) {
                Storage::delete('public/' . $user->user_foto);
            }
            $data['user_foto'] = $request->file('user_foto')->store('users', 'public');
        }

        $user->update($data);
        
        if ($request->has('role_id')) {
            $role = Role::findById($request->role_id);
            $user->syncRoles($role);
        }
        
        return response()->json(["status" => "success", "data" => $user], 200);
    }

    public function updatePassword(Request $request, $id)
    {
        $user = UserModel::find($id);
        if (!$user) {
            return response()->json(["status" => "error", "message" => "User not found"], 404);
        }

        if (!Hash::check($request->currentpassword, $user->user_password)) {
            return response()->json(["status" => "error", "message" => "Current password is incorrect"], 400);
        }

        $user->update(['user_password' => Hash::make($request->newpassword)]);
        return response()->json(["status" => "success", "message" => "Password updated successfully"], 200);
    }

    public function destroy($id)
    {
        $user = UserModel::find($id);
        if (!$user) {
            return response()->json(["status" => "error", "message" => "User not found"], 404);
        }

        if ($user->user_foto && Storage::exists('public/' . $user->user_foto)) {
            Storage::delete('public/' . $user->user_foto);
        }
        $user->delete();

        return response()->json(["status" => "success", "message" => "User deleted successfully"], 200);
    }
}
