<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Makanan & Minuman', 'slug' => 'makanan-minuman', 'icon' => 'utensils'],
            ['nama_kategori' => 'Fashion & Pakaian', 'slug' => 'fashion-pakaian', 'icon' => 'shirt'],
            ['nama_kategori' => 'Kerajinan Tangan', 'slug' => 'kerajinan-tangan', 'icon' => 'palette'],
            ['nama_kategori' => 'Jasa & Layanan', 'slug' => 'jasa-layanan', 'icon' => 'briefcase'],
            ['nama_kategori' => 'Pertanian & Perkebunan', 'slug' => 'pertanian-perkebunan', 'icon' => 'leaf'],
            ['nama_kategori' => 'Teknologi & Digital', 'slug' => 'teknologi-digital', 'icon' => 'laptop'],
            ['nama_kategori' => 'Kesehatan & Kecantikan', 'slug' => 'kesehatan-kecantikan', 'icon' => 'heart'],
            ['nama_kategori' => 'Pendidikan & Pelatihan', 'slug' => 'pendidikan-pelatihan', 'icon' => 'book'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'nama_kategori' => $category['nama_kategori'],
                'slug' => $category['slug'],
                'icon' => $category['icon'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
