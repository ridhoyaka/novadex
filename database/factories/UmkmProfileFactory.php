<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\District;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UmkmProfile>
 */
class UmkmProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaUsaha = fake()->company();
        
        return [
            'user_id' => User::factory(),
            'nama_usaha' => $namaUsaha,
            'slug' => Str::slug($namaUsaha),
            'kategori_id' => Category::factory(),
            'kecamatan_id' => District::factory(),
            'deskripsi' => fake()->paragraph(3),
            'whatsapp' => '08' . fake()->numerify('##########'),
            'logo_path' => null,
            'photos' => [],
            'is_published' => false,
            'latitude' => null,
            'longitude' => null,
            'alamat_lengkap' => null,
            'seo_title' => null,
            'seo_description' => null,
            'profile_completion_score' => 0,
        ];
    }
    
    /**
     * Indicate that the profile is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
        ]);
    }
    
    /**
     * Indicate that the profile has a logo.
     */
    public function withLogo(): static
    {
        return $this->state(fn (array $attributes) => [
            'logo_path' => 'logos/' . fake()->uuid() . '.jpg',
        ]);
    }
    
    /**
     * Indicate that the profile has photos.
     */
    public function withPhotos(int $count = 3): static
    {
        return $this->state(fn (array $attributes) => [
            'photos' => array_map(
                fn() => 'photos/' . fake()->uuid() . '.jpg',
                range(1, $count)
            ),
        ]);
    }
    
    /**
     * Indicate that the profile has location data.
     */
    public function withLocation(): static
    {
        return $this->state(fn (array $attributes) => [
            'latitude' => fake()->latitude(-7.8, -7.6),
            'longitude' => fake()->longitude(110.4, 110.6),
            'alamat_lengkap' => fake()->address(),
        ]);
    }
}
