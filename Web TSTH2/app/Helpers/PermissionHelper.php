<?php

if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        // Get permissions and roles from session
        $permissions = session('permissions', []);
        $roles = session('roles', []);

        // Superadmin bypass - has all permissions
        if (in_array('superadmin', $roles)) {
            return true;
        }

        // Check if permission exists in user's permissions
        return in_array($permission, $permissions);
    }
}