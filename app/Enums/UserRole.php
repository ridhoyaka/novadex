<?php

namespace App\Enums;

enum UserRole: string
{
    case UMKM = 'umkm';
    case ADMIN = 'admin';
    case SUPER_ADMIN = 'super_admin';
}
