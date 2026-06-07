<?php

namespace Tests\Unit\Migrations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CategoriesTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_table_has_correct_columns(): void
    {
        $this->assertTrue(Schema::hasTable('categories'));

        $columns = Schema::getColumnListing('categories');

        $this->assertContains('id', $columns);
        $this->assertContains('nama_kategori', $columns);
        $this->assertContains('slug', $columns);
        $this->assertContains('icon', $columns);
        $this->assertContains('created_at', $columns);
        $this->assertContains('updated_at', $columns);
    }

    public function test_categories_table_slug_column_has_unique_constraint(): void
    {
        DB::table('categories')->insert([
            'nama_kategori' => 'Test Category',
            'slug' => 'test-category',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->expectException(\Exception::class);

        DB::table('categories')->insert([
            'nama_kategori' => 'Another Category',
            'slug' => 'test-category',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
