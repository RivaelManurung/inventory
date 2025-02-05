<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role; // Menggunakan model Role dari Spatie
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\AksesModel;

class RoleController extends Controller
{
    // Menampilkan semua role
    public function index()
    {
        try {
            $roles = Role::all(); // Mengambil semua role menggunakan model Role dari Spatie
            return response()->json(['success' => true, 'data' => $roles], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Menambahkan role baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            // Menggunakan slug otomatis untuk role
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title)));
            
            // Membuat role baru menggunakan model Role dari Spatie
            $role = Role::create([
                'name' => $request->title,  // name adalah field yang digunakan oleh Spatie untuk role
                'description' => $request->desc
            ]);

            return response()->json(['success' => true, 'data' => $role], 201);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Menampilkan role berdasarkan ID
    public function show($id)
    {
        try {
            $role = Role::findById($id); // Menggunakan method findById dari Spatie
            return response()->json(['success' => true, 'data' => $role], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Role not found'], 404);
        }
    }

    // Memperbarui role
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'desc' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $role = Role::findById($id); // Menggunakan method findById dari Spatie
            $role->update([
                'name' => $request->title,
                'description' => $request->desc
            ]);

            return response()->json(['success' => true, 'data' => $role], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Role not found'], 404);
        }
    }

    // Menghapus role
    public function destroy($id)
    {
        try {
            $role = Role::findById($id); // Menggunakan method findById dari Spatie
            $role->delete();

            // Menghapus akses terkait role tersebut
            AksesModel::where('role_id', $id)->delete();

            return response()->json(['success' => true, 'message' => 'Role deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Role not found'], 404);
        }
    }
}
