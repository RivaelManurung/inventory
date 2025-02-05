<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Define permissions based on your routes
        $permissions = [
            'view gudang', 'create gudang', 'update gudang', 'delete gudang',
            'view satuan', 'create satuan', 'update satuan', 'delete satuan',
            'view jenisbarang', 'create jenisbarang', 'update jenisbarang', 'delete jenisbarang',
            'login', 'logout', 'register', 'refresh', 'profile'
        ];

        // Create permissions
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Create roles (using the data you provided)
        $roles = [
            [
                'role_title' => 'Super Admin',
                'role_slug' => 'super-admin',
                'role_desc' => '-',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'role_title' => 'Admin',
                'role_slug' => 'admin',
                'role_desc' => '-',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'role_title' => 'Operator',
                'role_slug' => 'operator',
                'role_desc' => '-',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        // Create roles
        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate(['name' => $roleData['role_slug']]);
            
            // Assign permissions to roles based on role slug
            if ($role->name == 'super-admin') {
                // Super Admin has all permissions
                $role->givePermissionTo($permissions);
            } elseif ($role->name == 'admin') {
                // Admin can have most permissions except login, register
                $adminPermissions = [
                    'view gudang', 'create gudang', 'update gudang', 'delete gudang',
                    'view satuan', 'create satuan', 'update satuan', 'delete satuan',
                    'view jenisbarang', 'create jenisbarang', 'update jenisbarang', 'delete jenisbarang',
                    'profile', 'refresh'
                ];
                $role->givePermissionTo($adminPermissions);
            } elseif ($role->name == 'operator') {
                // Operator can view and create, but cannot update or delete
                $operatorPermissions = [
                    'view gudang', 'view satuan', 'view jenisbarang', 'profile'
                ];
                $role->givePermissionTo($operatorPermissions);
            }
        }
    }
}
