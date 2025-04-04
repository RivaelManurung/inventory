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
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Auth
            'auth.logout',
            'auth.refresh',
            'auth.me',

            // User Access
            'user-access.permissions',
            'user-access.accessible-routes',
            'user-access.full-access-info',

            // Access Control
            'access-control.manage',
            'access-control.users.view',
            'access-control.permission.assign',
            'access-control.permission.revoke',
            'access-control.role.assign',
            'access-control.role.remove',
            'access-control.user-permissions.view',
            'access-control.user-routes.view',
            'access-control.user-info.view',

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
            'barang.barcode.view',
            'barang.barcode.download',

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

            // Stok
            'stok.view',
            'stok.create',
            'stok.edit',
            'stok.delete',

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
            'laporan.export',

            //Dashboard
            'dashboard.view',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
        }

        $superAdminRole = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'api'
        ])->givePermissionTo(Permission::all());

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'api'
        ])->givePermissionTo([
            'auth.logout',
            'auth.refresh',
            'auth.me',
            'user-access.permissions',
            'user-access.accessible-routes',
            'access-control.users.view',
            'gudang.view',
            'gudang.create',
            'gudang.edit',
            'barang.view',
            'barang.create',
            'barang.edit',
            'barang.barcode.view',
            'barang.barcode.download',
            'jenis-barang.view',
            'jenis-barang.create',
            'satuan.view',
            'satuan.create',
            'stok.view',
            'stok.edit',
            'transaksi.view',
            'transaksi.create',
            'peminjaman.view',
            'peminjaman.create',
            'pengembalian.view',
            'laporan.view',
            'dashboard.view',
        ]);

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
            ]
        ];

        foreach ($users as $userData) {
            $user = UserModel::firstOrCreate(
                ['user_email' => $userData['user_email']],
                [
                    'user_nama' => $userData['user_nama'],
                    'user_nmlengkap' => $userData['user_nmlengkap'],
                    'user_password' => Hash::make($userData['user_password']),
                ]
            );
            $user->assignRole($userData['role']);
        }
    }
}
