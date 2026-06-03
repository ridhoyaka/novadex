<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\District;
use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo UMKM users with profiles
        $categories = Category::all();
        $districts = District::all();
        
        $umkmData = [
            [
                'name' => 'Warung Makan Bu Siti',
                'email' => 'busiti@example.com',
                'category' => 'Makanan & Minuman',
                'description' => 'Warung makan tradisional dengan menu masakan Jawa yang lezat. Menyediakan nasi goreng, soto, dan berbagai lauk pauk.',
                'whatsapp' => '081234567890',
            ],
            [
                'name' => 'Batik Salatiga Indah',
                'email' => 'batik@example.com',
                'category' => 'Fashion & Pakaian',
                'description' => 'Produsen dan penjual batik khas Salatiga dengan motif tradisional dan modern. Melayani pemesanan seragam batik.',
                'whatsapp' => '081234567891',
            ],
            [
                'name' => 'Kerajinan Bambu Kreatif',
                'email' => 'bambu@example.com',
                'category' => 'Kerajinan Tangan',
                'description' => 'Membuat berbagai kerajinan dari bambu seperti keranjang, lampu hias, dan furniture. Produk ramah lingkungan.',
                'whatsapp' => '081234567892',
            ],
            [
                'name' => 'Jasa Desain Grafis Digital',
                'email' => 'design@example.com',
                'category' => 'Teknologi & Digital',
                'description' => 'Menyediakan jasa desain grafis, logo, banner, dan konten media sosial untuk UMKM dan bisnis.',
                'whatsapp' => '081234567893',
            ],
            [
                'name' => 'Salon Cantik Permata',
                'email' => 'salon@example.com',
                'category' => 'Kesehatan & Kecantikan',
                'description' => 'Salon kecantikan lengkap dengan layanan potong rambut, creambath, facial, dan perawatan kuku.',
                'whatsapp' => '081234567894',
            ],
        ];
        
        foreach ($umkmData as $index => $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'umkm',
            ]);
            
            $category = $categories->firstWhere('nama_kategori', $data['category']);
            $district = $districts->random();
            
            UmkmProfile::create([
                'user_id' => $user->id,
                'nama_usaha' => $data['name'],
                'slug' => \Illuminate\Support\Str::slug($data['name']),
                'kategori_id' => $category->id,
                'kecamatan_id' => $district->id,
                'deskripsi' => $data['description'],
                'whatsapp' => $data['whatsapp'],
                'is_published' => true,
            ]);
        }
        
        // Create admin user
        User::create([
            'name' => 'Admin ARSA',
            'email' => 'admin@arsa.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        // Create super admin user
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@arsa.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);
    }
}
