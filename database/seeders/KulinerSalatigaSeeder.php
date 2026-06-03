<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UmkmProfile;
use App\Models\Category;
use App\Models\District;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class KulinerSalatigaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create "Kuliner" category
        $kulinerCategory = Category::where('nama_kategori', 'Kuliner')->first();
        
        if (!$kulinerCategory) {
            $kulinerCategory = Category::create([
                'nama_kategori' => 'Kuliner',
                'slug' => 'kuliner',
            ]);
        }

        // Get default district (Sidorejo as default)
        $defaultDistrict = District::where('nama_kecamatan', 'Sidorejo')->first();
        if (!$defaultDistrict) {
            $defaultDistrict = District::first();
        }

        $umkmData = [
            [
                'nama_usaha' => 'Pastelo Singkong Keju D9',
                'deskripsi' => "Camilan khas Salatiga dengan cita rasa gurih dan renyah\n\nPastelo D9 dibuat dari singkong pilihan dengan isian keju gurih, dibalut kulit renyah, dan digoreng hingga keemasan. Cocok untuk camilan harian maupun oleh-oleh khas Salatiga.\n\n✨ Keunggulan:\n• Singkong lokal pilihan\n• Isian keju gurih dan lumer\n• Renyah di luar, lembut di dalam\n• Praktis untuk oleh-oleh\n\n📦 Pengiriman: Gosend • GrabExpress • JNE YES",
                'whatsapp' => '081234567890',
                'email' => 'pastelo.d9@gmail.com',
                'user_name' => 'Pastelo D9',
                'user_email' => 'pastelo.d9@gmail.com',
                'emoji' => '🥟',
                'maps_query' => 'Pastelo+D9+Salatiga',
            ],
            [
                'nama_usaha' => 'Sambal Tumpang Koyor Khas Salatiga',
                'deskripsi' => "Cita rasa tradisional kaya rempah\n\nSambal tumpang khas Salatiga dengan perpaduan tempe semangit dan koyor sapi yang empuk. Memiliki rasa gurih, legit, dan aroma khas Jawa.\n\n✨ Keunggulan:\n• Resep tradisional turun-temurun\n• Kaya rempah asli\n• Koyor empuk dan bumbu meresap\n• Cocok untuk lauk nasi hangat",
                'whatsapp' => '081234567891',
                'email' => 'sambaltumpang.salatiga@gmail.com',
                'user_name' => 'Sambal Tumpang Koyor',
                'user_email' => 'sambaltumpang.salatiga@gmail.com',
                'emoji' => '🍛',
                'maps_query' => 'Sambal+Tumpang+Koyor+Salatiga',
            ],
            [
                'nama_usaha' => 'Gethuk Ketek Khas Salatiga',
                'deskripsi' => "Jajanan legendaris ikon kota Salatiga\n\nGethuk ketek dibuat dari singkong kukus yang ditumbuk halus tanpa bahan pengawet, disajikan dengan kelapa parut segar dan rasa manis alami.\n\n✨ Keunggulan:\n• Legendaris & autentik\n• Tanpa pengawet\n• Tekstur lembut\n• Ikon kuliner Salatiga",
                'whatsapp' => '081234567892',
                'email' => 'gethukketek.salatiga@gmail.com',
                'user_name' => 'Gethuk Ketek Salatiga',
                'user_email' => 'gethukketek.salatiga@gmail.com',
                'emoji' => '🍠',
                'maps_query' => 'Gethuk+Ketek+Salatiga',
            ],
            [
                'nama_usaha' => 'Gethuk Crispy Argotelo',
                'deskripsi' => "Inovasi modern jajanan tradisional\n\nGethuk Argotelo hadir dengan tekstur crispy di luar dan lembut di dalam, dipadukan dengan keju gurih yang lumer. Cocok sebagai camilan kekinian maupun frozen food.\n\n✨ Keunggulan:\n• Crispy & lembut\n• Inovasi singkong + keju\n• Cocok untuk anak muda\n• Tersedia frozen food",
                'whatsapp' => '081234567893',
                'email' => 'argotelo.salatiga@gmail.com',
                'user_name' => 'Gethuk Argotelo',
                'user_email' => 'argotelo.salatiga@gmail.com',
                'emoji' => '🧀',
                'maps_query' => 'Gethuk+Crispy+Argotelo+Salatiga',
            ],
        ];

        foreach ($umkmData as $data) {
            // Check if user already exists
            $existingUser = User::where('email', $data['user_email'])->first();
            if ($existingUser) {
                $this->command->warn("⚠️  User already exists: {$data['user_email']}");
                continue;
            }

            // Create user account
            $user = User::create([
                'name' => $data['user_name'],
                'email' => $data['user_email'],
                'password' => Hash::make('password123'),
                'role' => 'umkm',
                'email_verified_at' => now(),
            ]);

            // Generate unique slug
            $slug = Str::slug($data['nama_usaha']);
            $originalSlug = $slug;
            $counter = 1;
            
            while (UmkmProfile::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Create UMKM profile
            $umkm = UmkmProfile::create([
                'user_id' => $user->id,
                'nama_usaha' => $data['nama_usaha'],
                'slug' => $slug,
                'kategori_id' => $kulinerCategory->id,
                'kecamatan_id' => $defaultDistrict->id,
                'deskripsi' => $data['deskripsi'],
                'whatsapp' => $data['whatsapp'],
                'is_published' => true,
            ]);

            $this->command->info("✅ Created: {$data['nama_usaha']}");
        }

        $this->command->info("\n🎉 Successfully added 4 UMKM kuliner khas Salatiga!");
        $this->command->info("📧 Default password for all accounts: password123");
    }
}
