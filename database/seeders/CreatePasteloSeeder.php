<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UmkmProfile;
use App\Models\Category;
use App\Models\District;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CreatePasteloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Kuliner category
        $kulinerCategory = Category::where('nama_kategori', 'Kuliner')->first();
        
        if (!$kulinerCategory) {
            $this->command->error("❌ Kategori Kuliner tidak ditemukan!");
            return;
        }

        // Get default district
        $defaultDistrict = District::where('nama_kecamatan', 'Sidorejo')->first();
        if (!$defaultDistrict) {
            $defaultDistrict = District::first();
        }

        // Check if user already exists
        $existingUser = User::where('email', 'pastelo.d9.salatiga@gmail.com')->first();
        
        if ($existingUser) {
            $this->command->warn("⚠️  User already exists, checking UMKM profile...");
            
            // Check if UMKM profile exists
            $existingUmkm = UmkmProfile::where('user_id', $existingUser->id)->first();
            
            if ($existingUmkm) {
                $this->command->info("✅ UMKM already exists: {$existingUmkm->nama_usaha}");
                
                // Update photo if not set
                if (!$existingUmkm->logo_path) {
                    $this->updatePhoto($existingUmkm);
                }
                return;
            }
        } else {
            // Create user account
            $existingUser = User::create([
                'name' => 'Pastelo D9',
                'email' => 'pastelo.d9.salatiga@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'umkm',
                'email_verified_at' => now(),
            ]);
            
            $this->command->info("✅ Created user: pastelo.d9.salatiga@gmail.com");
        }

        // Generate unique slug
        $slug = Str::slug('Pastelo Singkong Keju D9');
        $originalSlug = $slug;
        $counter = 1;
        
        while (UmkmProfile::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Create UMKM profile
        $umkm = UmkmProfile::create([
            'user_id' => $existingUser->id,
            'nama_usaha' => 'Pastelo Singkong Keju D9',
            'slug' => $slug,
            'kategori_id' => $kulinerCategory->id,
            'kecamatan_id' => $defaultDistrict->id,
            'deskripsi' => "Camilan khas Salatiga dengan cita rasa gurih dan renyah\n\nPastelo D9 dibuat dari singkong pilihan dengan isian keju gurih, dibalut kulit renyah, dan digoreng hingga keemasan. Cocok untuk camilan harian maupun oleh-oleh khas Salatiga.\n\n✨ Keunggulan:\n• Singkong lokal pilihan\n• Isian keju gurih dan lumer\n• Renyah di luar, lembut di dalam\n• Praktis untuk oleh-oleh\n\n📦 Pengiriman: Gosend • GrabExpress • JNE YES",
            'whatsapp' => '081234567890',
            'is_published' => true,
        ]);

        $this->command->info("✅ Created UMKM: {$umkm->nama_usaha}");

        // Update photo
        $this->updatePhoto($umkm);

        $this->command->info("\n🎉 Successfully created Pastelo D9!");
    }

    private function updatePhoto($umkm)
    {
        // Check if photo file exists
        $sourcePath = storage_path('app/public/pastelo.jfif');
        
        if (!File::exists($sourcePath)) {
            $this->command->warn("⚠️  Photo not found: pastelo.jfif");
            return;
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
