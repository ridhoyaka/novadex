<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    public function run(): void
    {
        $districts = [
            ['nama_kecamatan' => 'Argomulyo', 'latitude' => -7.3297, 'longitude' => 110.4925],
            ['nama_kecamatan' => 'Tingkir', 'latitude' => -7.3189, 'longitude' => 110.5042],
            ['nama_kecamatan' => 'Sidomukti', 'latitude' => -7.3356, 'longitude' => 110.5156],
            ['nama_kecamatan' => 'Sidorejo', 'latitude' => -7.3425, 'longitude' => 110.4856],
        ];

        foreach ($districts as $district) {
            DB::table('districts')->insert([
                'nama_kecamatan' => $district['nama_kecamatan'],
                'latitude' => $district['latitude'],
                'longitude' => $district['longitude'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
