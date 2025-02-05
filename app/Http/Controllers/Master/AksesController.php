<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Models\AksesModel;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AksesController extends BaseController
{
    public function getAksesByRole($role_id)
    {
        // Memeriksa apakah role ada
        $role = Role::findById($role_id);
        if (!$role) {
            return $this->sendError('Role not found', [], 404); // Menambahkan kode 404
        }

        $akses = AksesModel::where('role_id', $role_id)->get();
        if ($akses->isEmpty()) {
            return $this->sendError('No access found for this role', [], 404); // Menambahkan error jika akses tidak ditemukan
        }

        return $this->sendResponse($akses, 'Access data retrieved successfully');
    }

    public function addAkses(Request $request)
    {
        // Validasi data
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'menu_id' => 'nullable|exists:tbl_menu,menu_id',
            'submenu_id' => 'nullable|exists:tbl_submenu,submenu_id',
            'akses_type' => 'required|string'
        ]);

        // Menambahkan akses
        try {
            $akses = AksesModel::create($request->only(['role_id', 'menu_id', 'submenu_id', 'akses_type']));
            return $this->sendResponse($akses, 'Access added successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to add access', [$e->getMessage()], 500);
        }
    }

    public function removeAkses(Request $request)
    {
        // Validasi data
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'menu_id' => 'nullable|exists:tbl_menu,menu_id',
            'submenu_id' => 'nullable|exists:tbl_submenu,submenu_id',
            'akses_type' => 'required|string'
        ]);

        // Menghapus akses
        $deleted = AksesModel::where($request->only(['role_id', 'menu_id', 'submenu_id', 'akses_type']))->delete();

        if ($deleted) {
            return $this->sendResponse([], 'Access deleted successfully');
        }

        return $this->sendError('Access not found', [], 404); // Menambahkan kode 404
    }

    public function setAllAkses($role_id)
    {
        $role = Role::findById($role_id);
        if (!$role) {
            return $this->sendError('Role not found', [], 404);
        }

        AksesModel::where('role_id', $role_id)->delete();
        $data = [];

        foreach (MenuModel::all() as $menu) {
            foreach (['view', 'create', 'update', 'delete'] as $type) {
                $data[] = ['menu_id' => $menu->menu_id, 'role_id' => $role_id, 'akses_type' => $type, 'created_at' => now(), 'updated_at' => now()];
            }
        }

        foreach (SubmenuModel::all() as $submenu) {
            foreach (['view', 'create', 'update', 'delete'] as $type) {
                $data[] = ['submenu_id' => $submenu->submenu_id, 'role_id' => $role_id, 'akses_type' => $type, 'created_at' => now(), 'updated_at' => now()];
            }
        }

        // Memastikan akses berhasil diinsert
        if (AksesModel::insert($data)) {
            return $this->sendResponse([], 'All access set successfully');
        } else {
            return $this->sendError('Failed to set all access', [], 500); // Menambahkan error response jika insert gagal
        }
    }

    public function unsetAllAkses($role_id)
    {
        $deleted = AksesModel::where('role_id', $role_id)->delete();

        if ($deleted) {
            return $this->sendResponse([], 'All access removed successfully');
        }

        return $this->sendError('Failed to remove access', [], 500);
    }
}
