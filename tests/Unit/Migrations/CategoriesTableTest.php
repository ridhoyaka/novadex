<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

test('categories table has correct columns', function () {
    expect(Schema::hasTable('categories'))->toBeTrue();
    
    $columns = Schema::getColumnListing('categories');
    
    expect($columns)->toContain('id');
    expect($columns)->toContain('nama_kategori');
    expect($columns)->toContain('slug');
    expect($columns)->toContain('icon');
    expect($columns)->toContain('created_at');
    expect($columns)->toContain('updated_at');
});

test('categories table slug column has unique constraint', function () {
    // Create a category with a slug
    DB::table('categories')->insert([
        'nama_kategori' => 'Test Category',
        'slug' => 'test-category',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    
    // Attempt to insert another category with the same slug
    // This should throw an exception due to unique constraint
    expect(function () {
        DB::table('categories')->insert([
            'nama_kategori' => 'Another Category',
            'slug' => 'test-category',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    })->toThrow(Exception::class);
});
