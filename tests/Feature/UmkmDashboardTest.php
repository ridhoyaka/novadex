<?php

use App\Models\Category;
use App\Models\District;
use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('UMKM dashboard shows profile completion indicator', function () {
    $user = User::factory()->umkm()->create();
    $category = Category::factory()->create();
    $district = District::factory()->create();
    
    $profile = UmkmProfile::create([
        'user_id' => $user->id,
        'nama_usaha' => 'Warung Makan Sederhana',
        'slug' => 'warung-makan-sederhana',
        'kategori_id' => $category->id,
        'kecamatan_id' => $district->id,
        'deskripsi' => 'Deskripsi singkat',
        'whatsapp' => '081234567890',
        'is_published' => false,
    ]);
    
    $response = $this->actingAs($user)->get(route('umkm.dashboard'));
    
    $response->assertOk();
    $response->assertViewHas('completion');
    $response->assertViewHas('status');
    $response->assertViewHas('statusColor');
    $response->assertViewHas('missingFields');
});

test('dashboard calculates and updates profile completion score', function () {
    $user = User::factory()->umkm()->create();
    $category = Category::factory()->create();
    $district = District::factory()->create();
    
    $profile = UmkmProfile::create([
        'user_id' => $user->id,
        'nama_usaha' => 'Warung Makan Sederhana',
        'slug' => 'warung-makan-sederhana',
        'kategori_id' => $category->id,
        'kecamatan_id' => $district->id,
        'deskripsi' => str_repeat('a', 50),
        'whatsapp' => '081234567890',
        'logo_path' => 'logo.jpg',
        'is_published' => false,
        'profile_completion_score' => 0,
    ]);
    
    expect($profile->profile_completion_score)->toBe(0);
    
    $this->actingAs($user)->get(route('umkm.dashboard'));
    
    $profile->refresh();
    expect($profile->profile_completion_score)->toBe(90);
});

test('dashboard shows missing fields for incomplete profile', function () {
    $user = User::factory()->umkm()->create();
    $category = Category::factory()->create();
    $district = District::factory()->create();
    
    $profile = UmkmProfile::create([
        'user_id' => $user->id,
        'nama_usaha' => 'Warung Makan Sederhana',
        'slug' => 'warung-makan-sederhana',
        'kategori_id' => $category->id,
        'kecamatan_id' => $district->id,
        'deskripsi' => 'Short',
        'whatsapp' => '081234567890',
        'is_published' => false,
    ]);
    
    $response = $this->actingAs($user)->get(route('umkm.dashboard'));
    
    $response->assertOk();
    $missingFields = $response->viewData('missingFields');
    
    expect($missingFields)->toBeArray();
    expect($missingFields)->toContain('Deskripsi terlalu singkat (minimal 50 karakter)');
    expect($missingFields)->toContain('Belum ada foto usaha (minimal 1 foto dianjurkan)');
    expect($missingFields)->toContain('Lokasi usaha belum ditambahkan (opsional)');
});

test('dashboard redirects to profile edit if no profile exists', function () {
    $user = User::factory()->umkm()->create();
    
    $response = $this->actingAs($user)->get(route('umkm.dashboard'));
    
    $response->assertRedirect(route('umkm.profile.edit'));
    $response->assertSessionHas('info', 'Silakan lengkapi profil usaha Anda');
});

test('dashboard shows correct status for different completion levels', function () {
    $user = User::factory()->umkm()->create();
    $category = Category::factory()->create();
    $district = District::factory()->create();
    
    // Test Profil Lengkap (60%) - 4 required fields
    $profile = UmkmProfile::create([
        'user_id' => $user->id,
        'nama_usaha' => 'Warung Makan',
        'slug' => 'warung-makan',
        'kategori_id' => $category->id,
        'kecamatan_id' => $district->id,
        'deskripsi' => 'Short',
        'whatsapp' => '081234567890',
        'is_published' => false,
    ]);
    
    $response = $this->actingAs($user)->get(route('umkm.dashboard'));
    expect($response->viewData('completion'))->toBe(60); // 4 fields x 15% = 60%
    expect($response->viewData('status'))->toBe('Profil Lengkap');
    expect($response->viewData('statusColor'))->toBe('yellow');
    
    // Update to Profil Optimal (>= 80%)
    $profile->update([
        'deskripsi' => str_repeat('a', 50),
        'logo_path' => 'logo.jpg',
    ]);
    
    // Refresh user to get updated profile
    $user->refresh();
    
    $response = $this->actingAs($user)->get(route('umkm.dashboard'));
    expect($response->viewData('completion'))->toBe(90); // 6 fields x 15% = 90%
    expect($response->viewData('status'))->toBe('Profil Optimal');
    expect($response->viewData('statusColor'))->toBe('green');
});
