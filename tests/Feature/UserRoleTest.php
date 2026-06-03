<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

test('user can be created with umkm role by default', function () {
    $user = DB::table('users')->insertGetId([
        'name' => 'Test UMKM Owner',
        'email' => 'umkm@test.com',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    $createdUser = DB::table('users')->find($user);
    
    expect($createdUser)->not->toBeNull();
    expect($createdUser->role)->toBe('umkm');
});

test('user can be created with admin role', function () {
    $user = DB::table('users')->insertGetId([
        'name' => 'Test Admin',
        'email' => 'admin@test.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    $createdUser = DB::table('users')->find($user);
    
    expect($createdUser)->not->toBeNull();
    expect($createdUser->role)->toBe('admin');
});

test('user can be created with super_admin role', function () {
    $user = DB::table('users')->insertGetId([
        'name' => 'Test Super Admin',
        'email' => 'superadmin@test.com',
        'password' => Hash::make('password'),
        'role' => 'super_admin',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    $createdUser = DB::table('users')->find($user);
    
    expect($createdUser)->not->toBeNull();
    expect($createdUser->role)->toBe('super_admin');
});

test('email must be unique', function () {
    DB::table('users')->insert([
        'name' => 'First User',
        'email' => 'duplicate@test.com',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    // Attempting to insert another user with the same email should fail
    expect(fn() => DB::table('users')->insert([
        'name' => 'Second User',
        'email' => 'duplicate@test.com',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ]))->toThrow(Exception::class);
});

test('all three role types can coexist', function () {
    DB::table('users')->insert([
        ['name' => 'UMKM User', 'email' => 'umkm1@test.com', 'password' => Hash::make('password'), 'role' => 'umkm', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Admin User', 'email' => 'admin1@test.com', 'password' => Hash::make('password'), 'role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Super Admin User', 'email' => 'superadmin1@test.com', 'password' => Hash::make('password'), 'role' => 'super_admin', 'created_at' => now(), 'updated_at' => now()],
    ]);
    
    $umkmCount = DB::table('users')->where('role', 'umkm')->count();
    $adminCount = DB::table('users')->where('role', 'admin')->count();
    $superAdminCount = DB::table('users')->where('role', 'super_admin')->count();
    
    expect($umkmCount)->toBe(1);
    expect($adminCount)->toBe(1);
    expect($superAdminCount)->toBe(1);
});
