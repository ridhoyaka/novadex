<?php

namespace Tests\Unit\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UsersTableMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_table_has_expected_columns(): void
    {
        $this->assertTrue(Schema::hasTable('users'));
        
        $columns = [
            'id',
            'name',
            'email',
            'email_verified_at',
            'password',
            'role',
            'remember_token',
            'created_at',
            'updated_at',
        ];
        
        foreach ($columns as $column) {
            $this->assertTrue(
                Schema::hasColumn('users', $column),
                "Column '{$column}' does not exist in users table"
            );
        }
    }

    public function test_users_table_email_column_is_unique(): void
    {
        // Insert a user with an email
        DB::table('users')->insert([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'umkm',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Attempting to insert another user with the same email should fail
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        DB::table('users')->insert([
            'name' => 'Another User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'umkm',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function test_users_table_role_column_accepts_valid_enum_values(): void
    {
        // Test umkm role
        DB::table('users')->insert([
            'name' => 'UMKM User',
            'email' => 'umkm@test.com',
            'password' => bcrypt('password'),
            'role' => 'umkm',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $user1 = DB::table('users')->where('email', 'umkm@test.com')->first();
        $this->assertEquals('umkm', $user1->role);
        
        // Test admin role
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $user2 = DB::table('users')->where('email', 'admin@test.com')->first();
        $this->assertEquals('admin', $user2->role);
        
        // Test super_admin role
        DB::table('users')->insert([
            'name' => 'Super Admin User',
            'email' => 'superadmin@test.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $user3 = DB::table('users')->where('email', 'superadmin@test.com')->first();
        $this->assertEquals('super_admin', $user3->role);
    }

    public function test_users_table_role_column_has_default_value(): void
    {
        // Insert without specifying role
        DB::table('users')->insert([
            'name' => 'Default User',
            'email' => 'default@test.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $user = DB::table('users')->where('email', 'default@test.com')->first();
        $this->assertEquals('umkm', $user->role);
    }
}
