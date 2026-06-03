<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UmkmProfile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UpdateKulinerPhotosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mapping of UMKM names to their photo files
        $photoMapping = [
            'Pastelo Singkong Keju D9' => 'pastelo.jfif',
            'Sambal Tumpang Koyor Khas Salatiga' => 'tummpang koyor.jfif',
            'Gethuk Ketek Khas Salatiga' => 'getuk ketek.jfif',
            'Gethuk Crispy Argotelo' => 'argotello.jfif',
        ];

        foreach ($photoMapping as $umkmName => $photoFile) {
            // Find UMKM by name
            $umkm = UmkmProfile::where('nama_usaha', 'LIKE', "%{$umkmName}%")->first();
            
            if (!$umkm) {
                $this->command->warn("⚠️  UMKM not found: {$umkmName}");
                continue;
            }

            // Check if photo file exists in storage/app/public
            $sourcePath = storage_path('app/public/' . $photoFile);
            
            if (!File::exists($sourcePath)) {
                $this->command->warn("⚠️  Photo not found: {$photoFile}");
                continue;
            }

            // Create logos directory if it doesn't exist
            $logosDir = storage_path('app/public/logos');
            if (!File::exists($logosDir)) {
                File::makeDirectory($logosDir, 0755, true);
            }

            // Generate new filename
            $extension = pathinfo($photoFile, PATHINFO_EXTENSION);
            $newFilename = 'logo-' . $umkm->slug . '.' . $extension;
            $destinationPath = $logosDir . '/' . $newFilename;

            // Copy file to logos directory
            File::copy($sourcePath, $destinationPath);

            // Update UMKM profile with logo path
            $umkm->update([
                'logo_path' => 'logos/' . $newFilename,
            ]);

            $this->command->info("✅ Updated photo for: {$umkmName}");
            $this->command->info("   📁 File: logos/{$newFilename}");
        }

        $this->command->info("\n🎉 Successfully updated photos for UMKM kuliner!");
    }
}
