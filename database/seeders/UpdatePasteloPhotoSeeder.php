<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UmkmProfile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class UpdatePasteloPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find all UMKM with Pastelo in name
        $umkms = UmkmProfile::all();
        
        $this->command->info("Total UMKM in database: " . $umkms->count());
        
        foreach ($umkms as $umkm) {
            if (stripos($umkm->nama_usaha, 'Pastelo') !== false || stripos($umkm->nama_usaha, 'pastelo') !== false) {
                $this->command->info("Found: {$umkm->nama_usaha} (ID: {$umkm->id})");
                
                // Check if photo file exists
                $sourcePath = storage_path('app/public/pastelo.jfif');
                
                if (!File::exists($sourcePath)) {
                    $this->command->warn("⚠️  Photo not found: pastelo.jfif");
                    continue;
                }

                // Create logos directory if it doesn't exist
                $logosDir = storage_path('app/public/logos');
                if (!File::exists($logosDir)) {
                    File::makeDirectory($logosDir, 0755, true);
                }

                // Generate new filename
                $newFilename = 'logo-' . $umkm->slug . '.jfif';
                $destinationPath = $logosDir . '/' . $newFilename;

                // Copy file to logos directory
                File::copy($sourcePath, $destinationPath);

                // Update UMKM profile with logo path
                $umkm->update([
                    'logo_path' => 'logos/' . $newFilename,
                ]);

                $this->command->info("✅ Updated photo for: {$umkm->nama_usaha}");
                $this->command->info("   📁 File: logos/{$newFilename}");
            }
        }

        $this->command->info("\n🎉 Done!");
    }
}
