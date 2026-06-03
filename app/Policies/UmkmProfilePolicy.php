<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\UmkmProfile;
use App\Models\User;

class UmkmProfilePolicy
{
    public function view(User $user, UmkmProfile $profile): bool
    {
        // UMKM owners can view their own profile
        if ($user->isUmkm() && $profile->user_id === $user->id) {
            return true;
        }
        
        // Admins and super admins can view all profiles
        return $user->isAdmin() || $user->isSuperAdmin();
    }

    public function update(User $user, UmkmProfile $profile): bool
    {
        // Only UMKM owners can update their own profile
        if ($user->isUmkm() && $profile->user_id === $user->id) {
            return true;
        }
        
        // Super admins can update any profile
        return $user->isSuperAdmin();
    }

    public function delete(User $user, UmkmProfile $profile): bool
    {
        // Only super admins can delete profiles
        return $user->isSuperAdmin();
    }

    public function publish(User $user, UmkmProfile $profile): bool
    {
        // UMKM owners can publish their own profile
        if ($user->isUmkm() && $profile->user_id === $user->id) {
            return true;
        }
        
        // Super admins can publish any profile
        return $user->isSuperAdmin();
    }
}
