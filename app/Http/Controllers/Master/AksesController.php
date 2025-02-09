<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\BaseController;
use App\Models\AksesModel;
use App\Models\MenuModel;
use App\Models\SubmenuModel;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class AksesController extends BaseController
{
    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         if (!Auth::check() || !Auth::user()->hasRole('superadmin', 'api')) {
    //             return $this->sendError('Unauthorized access', [], 403);
    //         }
    //         return $next($request);
    //     });
        
        
    // }

    public function getAksesByRole($role_id)
    {
        try {
            $role = Role::findById($role_id, 'api');
            if (!$role) {
                return $this->sendError('Role not found', [], 404);
            }

            $akses = AksesModel::where('role_id', $role_id)->get();
            if ($akses->isEmpty()) {
                return $this->sendError('No access found for this role', [], 404);
            }

            return $this->sendResponse($akses, 'Access data retrieved successfully');
        } catch (Exception $e) {
            return $this->sendError('Server Error', [$e->getMessage()], 500);
        }
    }

    public function addAkses(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'role_id' => 'required|exists:roles,id',
                'menu_id' => 'nullable|exists:tbl_menu,menu_id',
                'submenu_id' => 'nullable|exists:tbl_submenu,submenu_id',
                'akses_type' => 'required|string'
            ]);

            $akses = AksesModel::create($validatedData);
            return $this->sendResponse($akses, 'Access added successfully');
        } catch (ValidationException $e) {
            return $this->sendError('Validation Error', $e->errors(), 422);
        } catch (Exception $e) {
            return $this->sendError('Failed to add access', [$e->getMessage()], 500);
        }
    }

    public function removeAkses(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'role_id' => 'required|exists:roles,id',
                'menu_id' => 'nullable|exists:tbl_menu,menu_id',
                'submenu_id' => 'nullable|exists:tbl_submenu,submenu_id',
                'akses_type' => 'required|string'
            ]);

            $deleted = AksesModel::where($validatedData)->delete();

            if ($deleted) {
                return $this->sendResponse([], 'Access deleted successfully');
            }
            return $this->sendError('Access not found', [], 404);
        } catch (ValidationException $e) {
            return $this->sendError('Validation Error', $e->errors(), 422);
        } catch (Exception $e) {
            return $this->sendError('Failed to remove access', [$e->getMessage()], 500);
        }
    }

    public function setAllAkses($role_id)
    {
        try {
            $role = Role::findById($role_id, 'api');
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

            AksesModel::insert($data);
            return $this->sendResponse([], 'All access set successfully');
        } catch (Exception $e) {
            return $this->sendError('Failed to set all access', [$e->getMessage()], 500);
        }
    }

    public function unsetAllAkses($role_id)
    {
        try {
            $deleted = AksesModel::where('role_id', $role_id)->delete();
            if ($deleted) {
                return $this->sendResponse([], 'All access removed successfully');
            }
            return $this->sendError('Failed to remove access', [], 500);
        } catch (Exception $e) {
            return $this->sendError('Failed to remove access', [$e->getMessage()], 500);
        }
    }
}
