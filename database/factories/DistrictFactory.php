<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\District>
 */
class DistrictFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_kecamatan' => fake()->randomElement([
                'Sidorejo',
                'Sidomukti',
                'Argomulyo',
                'Tingkir',
            ]),
            'latitude' => fake()->latitude(-7.8, -7.6),
            'longitude' => fake()->longitude(110.4, 110.6),
        ];
    }
}
