<?php
namespace App\Http\Repositories;

use App\Models\UserModel;

class UserRepository
{
    public function findByUsername(string $username)
    {
        return UserModel::where('user_nama', $username)->first();
    }

    public function getUserWithRolesPermissions(int $userId)
    {
        return UserModel::with(['roles.permissions'])
            ->findOrFail($userId);
    }
}