<?php

use App\Models\Category;
use App\Models\District;
use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('auto generates SEO metadata when profile is created', function () {
    $user = User::factory()->umkm()->create();
    $category = Category::factory()->create(['nama_kategori' => 'Kuliner']);
    $district = District::factory()->create(['nama_kecamatan' => 'Sidorejo']);
    
    $profile = UmkmProfile::create([
        'user_id' => $user->id,
        'nama_usaha' => 'Warung Makan Sederhana',
        'slug' => 'warung-makan-sederhana',
        'kategori_id' => $category->id,
        'kecamatan_id' => $district->id,
        'deskripsi' => 'Warung makan dengan menu masakan rumahan yang lezat dan terjangkau untuk semua kalangan.',
        'whatsapp' => '081234567890',
        'is_published' => false,
    ]);
    
    expect($profile->seo_title)->not->toBeNull();
    expect($profile->seo_title)->toContain('Warung Makan Sederhana');
    expect($profile->seo_title)->toContain('NovaDex');
    
    expect($profile->seo_description)->not->toBeNull();
    expect($profile->seo_description)->toContain('Warung makan');
});

test('auto regenerates SEO metadata when nama_usaha is updated', function () {
    $user = User::factory()->umkm()->create();
    $category = Category::factory()->create(['nama_kategori' => 'Kuliner']);
    $district = District::factory()->create(['nama_kecamatan' => 'Sidorejo']);
    
    $profile = UmkmProfile::create([
        'user_id' => $user->id,
        'nama_usaha' => 'Warung Makan Lama',
        'slug' => 'warung-makan-lama',
        'kategori_id' => $category->id,
        'kecamatan_id' => $district->id,
        'deskripsi' => 'Deskripsi warung makan.',
        'whatsapp' => '081234567890',
        'is_published' => false,
    ]);
    
    $oldTitle = $profile->seo_title;
    
    $profile->update([
        'nama_usaha' => 'Warung Makan Baru',
    ]);
    
    expect($profile->seo_title)->not->toBe($oldTitle);
    expect($profile->seo_title)->toContain('Warung Makan Baru');
});

test('auto regenerates SEO metadata when deskripsi is updated', function () {
    $user = User::factory()->umkm()->create();
    $category = Category::factory()->create(['nama_kategori' => 'Kuliner']);
    $district = District::factory()->create(['nama_kecamatan' => 'Sidorejo']);
    
    $profile = UmkmProfile::create([
        'user_id' => $user->id,
        'nama_usaha' => 'Warung Makan Sederhana',
        'slug' => 'warung-makan-sederhana',
        'kategori_id' => $category->id,
        'kecamatan_id' => $district->id,
        'deskripsi' => 'Deskripsi lama.',
        'whatsapp' => '081234567890',
        'is_published' => false,
    ]);
    
    $oldDescription = $profile->seo_description;
    
    $profile->update([
        'deskripsi' => 'Deskripsi baru dengan menu masakan rumahan yang lezat dan terjangkau.',
    ]);
    
    expect($profile->seo_description)->not->toBe($oldDescription);
    expect($profile->seo_description)->toContain('Deskripsi baru');
});

test('auto regenerates SEO metadata when kategori is changed', function () {
    $user = User::factory()->umkm()->create();
    $category1 = Category::factory()->create(['nama_kategori' => 'Kuliner']);
    $category2 = Category::factory()->create(['nama_kategori' => 'Fashion']);
    $district = District::factory()->create(['nama_kecamatan' => 'Sidorejo']);
    
    $profile = UmkmProfile::create([
        'user_id' => $user->id,
        'nama_usaha' => 'Toko Sederhana',
        'slug' => 'toko-sederhana',
        'kategori_id' => $category1->id,
        'kecamatan_id' => $district->id,
        'deskripsi' => 'Deskripsi toko.',
        'whatsapp' => '081234567890',
        'is_published' => false,
    ]);
    
    $oldTitle = $profile->seo_title;
    
    $profile->update([
        'kategori_id' => $category2->id,
    ]);
    
    // Refresh to get updated SEO
    $profile = $profile->fresh();
    
    expect($profile->seo_title)->not->toBe($oldTitle);
    expect($profile->seo_title)->toContain('Fashion');
});

test('does not regenerate SEO when irrelevant fields are updated', function () {
    $user = User::factory()->umkm()->create();
    $category = Category::factory()->create(['nama_kategori' => 'Kuliner']);
    $district = District::factory()->create(['nama_kecamatan' => 'Sidorejo']);
    
    $profile = UmkmProfile::create([
        'user_id' => $user->id,
        'nama_usaha' => 'Warung Makan Sederhana',
        'slug' => 'warung-makan-sederhana',
        'kategori_id' => $category->id,
        'kecamatan_id' => $district->id,
        'deskripsi' => 'Deskripsi warung makan.',
        'whatsapp' => '081234567890',
        'is_published' => false,
    ]);
    
    $oldTitle = $profile->seo_title;
    $oldDescription = $profile->seo_description;
    
    $profile->update([
        'is_published' => true,
    ]);
    
    expect($profile->seo_title)->toBe($oldTitle);
    expect($profile->seo_description)->toBe($oldDescription);
});

test('SEO title is limited to 60 characters', function () {
    $user = User::factory()->umkm()->create();
    $category = Category::factory()->create(['nama_kategori' => 'Kuliner dan Makanan Tradisional']);
    $district = District::factory()->create(['nama_kecamatan' => 'Sidorejo Lor Kidul']);
    
    $profile = UmkmProfile::create([
        'user_id' => $user->id,
        'nama_usaha' => 'Warung Makan Sederhana Dengan Nama Yang Sangat Panjang Sekali',
        'slug' => 'warung-makan-sederhana',
        'kategori_id' => $category->id,
        'kecamatan_id' => $district->id,
        'deskripsi' => 'Deskripsi warung makan.',
        'whatsapp' => '081234567890',
        'is_published' => false,
    ]);
    
    expect(strlen($profile->seo_title))->toBeLessThanOrEqual(60);
});

test('SEO description is limited to 155 characters', function () {
    $user = User::factory()->umkm()->create();
    $category = Category::factory()->create(['nama_kategori' => 'Kuliner']);
    $district = District::factory()->create(['nama_kecamatan' => 'Sidorejo']);
    
    $longDescription = 'Warung makan dengan menu masakan rumahan yang lezat dan terjangkau. Kami menyediakan berbagai pilihan menu nasi, lauk pauk, sayur mayur, dan minuman segar setiap hari dengan harga yang sangat terjangkau untuk semua kalangan masyarakat.';
    
    $profile = UmkmProfile::create([
        'user_id' => $user->id,
        'nama_usaha' => 'Warung Makan Sederhana',
        'slug' => 'warung-makan-sederhana',
        'kategori_id' => $category->id,
        'kecamatan_id' => $district->id,
        'deskripsi' => $longDescription,
        'whatsapp' => '081234567890',
        'is_published' => false,
    ]);
    
    expect(strlen($profile->seo_description))->toBeLessThanOrEqual(155);
});
