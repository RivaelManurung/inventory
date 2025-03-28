<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserModel;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar semua permission
        $permissions = [
            // Gudang
            'gudang.view',
            'gudang.create',
            'gudang.edit',
            'gudang.delete',
            
            // Barang
            'barang.view',
            'barang.create',
            'barang.edit',
            'barang.delete',
            
            // Satuan
            'satuan.view',
            'satuan.create',
            'satuan.edit',
            'satuan.delete',
            
            // Jenis Barang
            'jenis-barang.view',
            'jenis-barang.create',
            'jenis-barang.edit',
            'jenis-barang.delete',
            
            // User Management
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
            
            // Role Management
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',
            
            // Permission Management
            'permission.view',
            'permission.create',
            'permission.edit',
            'permission.delete',
            
            // Assign Permission
            'assign.permission' // Tambahan agar superadmin bisa assign permission
        ];

        // Buat permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
        }

        // Buat role dan assign permission
        $superAdminRole = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'api'
        ])->givePermissionTo(Permission::all()); // Superadmin dapat semua izin

        $adminRole = Role::firstOrCreate([
            'name' => 'admin', 
            'guard_name' => 'api'
        ])->givePermissionTo([
            'gudang.view', 'gudang.create', 'gudang.edit',
            'barang.view', 'barang.create', 'barang.edit',
            'satuan.view', 'satuan.create',
            'user.view'
        ]);

        $managerRole = Role::firstOrCreate([
            'name' => 'manager',
            'guard_name' => 'api'
        ])->givePermissionTo([
            'gudang.view', 'gudang.create',
            'barang.view', 'barang.create',
            'satuan.view'
        ]);

        $operatorRole = Role::firstOrCreate([
            'name' => 'operator',
            'guard_name' => 'api'
        ])->givePermissionTo([
            'gudang.view',
            'barang.view'
        ]);

        // Buat user dan assign role
        $users = [
            [
                'username' => 'superadmin',
                'name' => 'Super Administrator',
                'email' => 'superadmin@example.com',
                'password' => 'password123',
                'role' => 'superadmin'
            ],
            [
                'username' => 'admin',
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => 'password123',
                'role' => 'admin'
            ],
            [
                'username' => 'manager',
                'name' => 'Manager Gudang',
                'email' => 'manager@example.com',
                'password' => 'password123',
                'role' => 'manager'
            ],
            [
                'username' => 'operator',
                'name' => 'Operator Gudang',
                'email' => 'operator@example.com',
                'password' => 'password123',
                'role' => 'operator'
            ]
        ];

        foreach ($users as $userData) {
            $user = UserModel::firstOrCreate(
                ['user_nama' => $userData['username']],
                [
                    'user_nmlengkap' => $userData['name'],
                    'user_email' => $userData['email'],
                    'user_password' => Hash::make($userData['password']),
                ]
            );
            $user->assignRole($userData['role']);
        }
    }
}
