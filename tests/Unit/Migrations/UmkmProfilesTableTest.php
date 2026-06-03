<?php

namespace Tests\Unit\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UmkmProfilesTableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function umkm_profiles_table_has_expected_columns(): void
    {
        $this->assertTrue(Schema::hasTable('umkm_profiles'));
        
        $columns = [
            'id',
            'user_id',
            'nama_usaha',
            'slug',
            'kategori_id',
            'kecamatan_id',
            'deskripsi',
            'whatsapp',
            'logo_path',
            'photos',
            'is_published',
            'created_at',
            'updated_at',
        ];
        
        foreach ($columns as $column) {
            $this->assertTrue(
                Schema::hasColumn('umkm_profiles', $column),
                "Column '{$column}' does not exist in umkm_profiles table"
            );
        }
    }

    /** @test */
    public function umkm_profiles_table_has_expected_indexes(): void
    {
        $indexes = Schema::getIndexes('umkm_profiles');
        $indexNames = array_column($indexes, 'name');
        
        // Check for key indexes
        $this->assertContains('umkm_profiles_slug_index', $indexNames);
        $this->assertContains('umkm_profiles_is_published_index', $indexNames);
        $this->assertContains('umkm_profiles_kategori_id_index', $indexNames);
        $this->assertContains('umkm_profiles_kecamatan_id_index', $indexNames);
    }

    /** @test */
    public function umkm_profiles_table_has_foreign_keys(): void
    {
        $foreignKeys = Schema::getForeignKeys('umkm_profiles');
        $foreignKeyColumns = array_column($foreignKeys, 'columns');
        
        // Flatten the array since columns is an array
        $foreignKeyColumns = array_merge(...$foreignKeyColumns);
        
        $this->assertContains('user_id', $foreignKeyColumns);
        $this->assertContains('kategori_id', $foreignKeyColumns);
        $this->assertContains('kecamatan_id', $foreignKeyColumns);
    }

    /** @test */
    public function user_id_must_be_unique(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        // Create first profile
        \Illuminate\Support\Facades\DB::table('umkm_profiles')->insert([
            'user_id' => 1,
            'nama_usaha' => 'Test Business 1',
            'slug' => 'test-business-1',
            'kategori_id' => 1,
            'kecamatan_id' => 1,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Try to create second profile with same user_id (should fail)
        \Illuminate\Support\Facades\DB::table('umkm_profiles')->insert([
            'user_id' => 1,
            'nama_usaha' => 'Test Business 2',
            'slug' => 'test-business-2',
            'kategori_id' => 1,
            'kecamatan_id' => 1,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /** @test */
    public function slug_must_be_unique(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        // Create first profile
        \Illuminate\Support\Facades\DB::table('umkm_profiles')->insert([
            'user_id' => 1,
            'nama_usaha' => 'Test Business',
            'slug' => 'test-business',
            'kategori_id' => 1,
            'kecamatan_id' => 1,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Try to create second profile with same slug (should fail)
        \Illuminate\Support\Facades\DB::table('umkm_profiles')->insert([
            'user_id' => 2,
            'nama_usaha' => 'Test Business',
            'slug' => 'test-business',
            'kategori_id' => 1,
            'kecamatan_id' => 1,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
