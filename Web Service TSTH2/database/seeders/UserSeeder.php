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

        // Daftar semua permission untuk seluruh tabel
        $permissions = [
            // User Management
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
            
            // Role & Permission Management
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',
            'permission.view',
            'permission.create',
            'permission.edit',
            'permission.delete',
            'assign.permission',
            
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
            
            // Jenis Barang
            'jenis-barang.view',
            'jenis-barang.create',
            'jenis-barang.edit',
            'jenis-barang.delete',
            
            // Satuan
            'satuan.view',
            'satuan.create',
            'satuan.edit',
            'satuan.delete',
            
            // Status Barang
            'status-barang.view',
            'status-barang.create',
            'status-barang.edit',
            'status-barang.delete',
            
            // Barang Gudang (Stok)
            'stok.view',
            'stok.create',
            'stok.edit',
            'stok.delete',
            
            // Jenis Transaksi
            'jenis-transaksi.view',
            'jenis-transaksi.create',
            'jenis-transaksi.edit',
            'jenis-transaksi.delete',
            
            // Transaksi
            'transaksi.view',
            'transaksi.create',
            'transaksi.edit',
            'transaksi.delete',
            
            // Detail Transaksi
            'transaksi-detail.view',
            'transaksi-detail.create',
            'transaksi-detail.edit',
            'transaksi-detail.delete',
            
            // Peminjaman
            'peminjaman.view',
            'peminjaman.create',
            'peminjaman.edit',
            'peminjaman.delete',
            'peminjaman.approve',
            'peminjaman.cancel',
            
            // Pengembalian
            'pengembalian.view',
            'pengembalian.create',
            'pengembalian.edit',
            'pengembalian.delete',
            
            // Laporan
            'laporan.view',
            'laporan.generate',
            'laporan.export'
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
        ])->givePermissionTo(Permission::all());

        $adminRole = Role::firstOrCreate([
            'name' => 'admin', 
            'guard_name' => 'api'
        ])->givePermissionTo([
            // Gudang
            'gudang.view', 'gudang.create', 'gudang.edit',
            
            // Barang
            'barang.view', 'barang.create', 'barang.edit',
            
            // Jenis Barang
            'jenis-barang.view', 'jenis-barang.create',
            
            // Satuan
            'satuan.view', 'satuan.create',
            
            // Status Barang
            'status-barang.view',
            
            // Stok
            'stok.view', 'stok.edit',
            
            // Transaksi
            'transaksi.view', 'transaksi.create',
            'transaksi-detail.view',
            
            // Peminjaman
            'peminjaman.view', 'peminjaman.create', 'peminjaman.approve',
            
            // Pengembalian
            'pengembalian.view', 'pengembalian.create',
            
            // Laporan
            'laporan.view', 'laporan.generate',
            
            // User
            'user.view'
        ]);

        $managerRole = Role::firstOrCreate([
            'name' => 'manager',
            'guard_name' => 'api'
        ])->givePermissionTo([
            'gudang.view',
            'barang.view',
            'jenis-barang.view',
            'satuan.view',
            'status-barang.view',
            'stok.view',
            'transaksi.view',
            'transaksi-detail.view',
            'peminjaman.view',
            'pengembalian.view',
            'laporan.view'
        ]);

        $operatorRole = Role::firstOrCreate([
            'name' => 'operator',
            'guard_name' => 'api'
        ])->givePermissionTo([
            'barang.view',
            'stok.view',
            'transaksi.view',
            'peminjaman.view',
            'pengembalian.view'
        ]);

        // Buat user dan assign role
        $users = [
            [
                'user_nama' => 'superadmin',
                'user_nmlengkap' => 'Super Administrator',
                'user_email' => 'superadmin@example.com',
                'user_password' => 'password123',
                'role' => 'superadmin'
            ],
            [
                'user_nama' => 'admin',
                'user_nmlengkap' => 'Administrator',
                'user_email' => 'admin@example.com',
                'user_password' => 'password123',
                'role' => 'admin'
            ],
            [
                'user_nama' => 'manager',
                'user_nmlengkap' => 'Manager Gudang',
                'user_email' => 'manager@example.com',
                'user_password' => 'password123',
                'role' => 'manager'
            ],
            [
                'user_nama' => 'operator',
                'user_nmlengkap' => 'Operator Gudang',
                'user_email' => 'operator@example.com',
                'user_password' => 'password123',
                'role' => 'operator'
            ]
        ];

        foreach ($users as $userData) {
            $user = UserModel::firstOrCreate(
                ['user_nama' => $userData['user_nama']],
                [
                    'user_nmlengkap' => $userData['user_nmlengkap'],
                    'user_email' => $userData['user_email'],
                    'user_password' => Hash::make($userData['user_password']),
                ]
            );
            $user->assignRole($userData['role']);
        }
    }
}