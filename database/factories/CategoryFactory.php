<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaKategori = fake()->unique()->randomElement([
            'Kuliner',
            'Fashion',
            'Kerajinan',
            'Jasa',
            'Pertanian',
            'Teknologi',
            'Otomotif',
            'Kesehatan',
            'Pendidikan',
            'Elektronik',
        ]);
        
        return [
            'nama_kategori' => $namaKategori,
            'slug' => Str::slug($namaKategori),
            'icon' => null,
        ];
    }
}
