<?php

use App\Models\Category;
use App\Models\District;
use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Admin Dashboard Controller', function () {
    
    test('admin can access dashboard', function () {
        $admin = User::factory()->admin()->create();
        
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        
        $response->assertOk();
        $response->assertViewIs('admin.dashboard');
    });
    
    test('super admin can access admin dashboard', function () {
        $superAdmin = User::factory()->superAdmin()->create();
        
        $response = $this->actingAs($superAdmin)->get(route('admin.dashboard'));
        
        $response->assertOk();
        $response->assertViewIs('admin.dashboard');
    });
    
    test('dashboard displays statistics', function () {
        $admin = User::factory()->admin()->create();
        
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        
        $response->assertOk();
        $response->assertViewHas('stats');
        
        $stats = $response->viewData('stats');
        expect($stats)->toHaveKeys([
            'total_umkm',
            'published_umkm',
            'unpublished_umkm',
            'total_users',
            'total_categories',
            'total_districts',
            'without_photos',
            'short_descriptions',
            'without_location',
            'inactive_profiles',
            'low_completion',
        ]);
    });
    
    test('dashboard displays UMKM by category', function () {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->umkm()->create();
        $category = Category::factory()->create(['nama_kategori' => 'Food']);
        $district = District::factory()->create();
        
        UmkmProfile::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Test Business',
            'slug' => 'test-business',
            'kategori_id' => $category->id,
            'kecamatan_id' => $district->id,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => true,
        ]);
        
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        
        $response->assertOk();
        $response->assertViewHas('umkmByCategory');
        
        $umkmByCategory = $response->viewData('umkmByCategory');
        expect($umkmByCategory)->not->toBeEmpty();
    });
    
    test('dashboard displays UMKM by district', function () {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->umkm()->create();
        $category = Category::factory()->create();
        $district = District::factory()->create(['nama_kecamatan' => 'District A']);
        
        UmkmProfile::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Test Business',
            'slug' => 'test-business',
            'kategori_id' => $category->id,
            'kecamatan_id' => $district->id,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => true,
        ]);
        
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        
        $response->assertOk();
        $response->assertViewHas('umkmByDistrict');
        
        $umkmByDistrict = $response->viewData('umkmByDistrict');
        expect($umkmByDistrict)->not->toBeEmpty();
    });
    
    test('dashboard displays recent UMKM', function () {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->umkm()->create();
        $category = Category::factory()->create();
        $district = District::factory()->create();
        
        UmkmProfile::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Recent Business',
            'slug' => 'recent-business',
            'kategori_id' => $category->id,
            'kecamatan_id' => $district->id,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => true,
        ]);
        
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        
        $response->assertOk();
        $response->assertViewHas('recentUmkm');
        
        $recentUmkm = $response->viewData('recentUmkm');
        expect($recentUmkm)->toHaveCount(1);
        expect($recentUmkm->first()->nama_usaha)->toBe('Recent Business');
    });
    
    test('dashboard calculates data quality indicators correctly', function () {
        $admin = User::factory()->admin()->create();
        $user1 = User::factory()->umkm()->create();
        $user2 = User::factory()->umkm()->create();
        $user3 = User::factory()->umkm()->create();
        $category = Category::factory()->create();
        $district = District::factory()->create();
        
        // Profile without photo
        UmkmProfile::create([
            'user_id' => $user1->id,
            'nama_usaha' => 'No Photo Business',
            'slug' => 'no-photo-business',
            'kategori_id' => $category->id,
            'kecamatan_id' => $district->id,
            'deskripsi' => str_repeat('a', 100),
            'whatsapp' => '081234567890',
            'logo_path' => null,
            'photos' => [],
            'is_published' => true,
        ]);
        
        // Profile with short description
        UmkmProfile::create([
            'user_id' => $user2->id,
            'nama_usaha' => 'Short Desc Business',
            'slug' => 'short-desc-business',
            'kategori_id' => $category->id,
            'kecamatan_id' => $district->id,
            'deskripsi' => 'Short',
            'whatsapp' => '081234567890',
            'logo_path' => 'logo.jpg',
            'is_published' => true,
        ]);
        
        // Profile without location
        UmkmProfile::create([
            'user_id' => $user3->id,
            'nama_usaha' => 'No Location Business',
            'slug' => 'no-location-business',
            'kategori_id' => $category->id,
            'kecamatan_id' => $district->id,
            'deskripsi' => str_repeat('a', 100),
            'whatsapp' => '081234567890',
            'logo_path' => 'logo.jpg',
            'latitude' => null,
            'longitude' => null,
            'is_published' => true,
        ]);
        
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        
        $response->assertOk();
        $stats = $response->viewData('stats');
        
        expect($stats['without_photos'])->toBe(1);
        expect($stats['short_descriptions'])->toBe(1);
        expect($stats['without_location'])->toBe(3); // All 3 profiles have no location
    });
    
    test('UMKM cannot access admin dashboard', function () {
        $umkm = User::factory()->umkm()->create();
        
        $response = $this->actingAs($umkm)->get(route('admin.dashboard'));
        
        $response->assertForbidden();
    });
    
    test('guest cannot access admin dashboard', function () {
        $response = $this->get(route('admin.dashboard'));
        
        $response->assertRedirect(route('login'));
    });
});
