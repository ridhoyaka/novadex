<?php

use App\Models\Category;
use App\Models\District;
use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('SuperAdmin Dashboard Controller', function () {
    
    test('super admin can access dashboard', function () {
        $superAdmin = User::factory()->superAdmin()->create();
        
        $response = $this->actingAs($superAdmin)->get(route('superadmin.dashboard'));
        
        $response->assertOk();
        $response->assertViewIs('superadmin.dashboard');
    });
    
    test('dashboard displays system statistics', function () {
        $superAdmin = User::factory()->superAdmin()->create();
        
        $response = $this->actingAs($superAdmin)->get(route('superadmin.dashboard'));
        
        $response->assertOk();
        $response->assertViewHas('stats');
        
        $stats = $response->viewData('stats');
        expect($stats)->toHaveKeys([
            'total_users',
            'umkm_users',
            'admin_users',
            'total_umkm',
            'published_umkm',
            'total_categories',
            'total_districts',
            'recent_activities',
        ]);
    });
    
    test('dashboard displays aggregate data only', function () {
        $superAdmin = User::factory()->superAdmin()->create();
        
        // Create some test data
        User::factory()->umkm()->count(5)->create();
        User::factory()->admin()->count(2)->create();
        
        $response = $this->actingAs($superAdmin)->get(route('superadmin.dashboard'));
        
        $response->assertOk();
        $stats = $response->viewData('stats');
        
        // Should show counts, not individual records
        expect($stats['umkm_users'])->toBe(5);
        expect($stats['admin_users'])->toBe(2);
        expect($stats['total_users'])->toBeGreaterThanOrEqual(7); // 5 UMKM + 2 admin + 1 superadmin
    });
    
    test('dashboard displays UMKM by category distribution', function () {
        $superAdmin = User::factory()->superAdmin()->create();
        $user1 = User::factory()->umkm()->create();
        $user2 = User::factory()->umkm()->create();
        $category1 = Category::factory()->create(['nama_kategori' => 'Food']);
        $category2 = Category::factory()->create(['nama_kategori' => 'Fashion']);
        $district = District::factory()->create();
        
        UmkmProfile::create([
            'user_id' => $user1->id,
            'nama_usaha' => 'Food Business',
            'slug' => 'food-business',
            'kategori_id' => $category1->id,
            'kecamatan_id' => $district->id,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => true,
        ]);
        
        UmkmProfile::create([
            'user_id' => $user2->id,
            'nama_usaha' => 'Fashion Business',
            'slug' => 'fashion-business',
            'kategori_id' => $category2->id,
            'kecamatan_id' => $district->id,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => true,
        ]);
        
        $response = $this->actingAs($superAdmin)->get(route('superadmin.dashboard'));
        
        $response->assertOk();
        $response->assertViewHas('umkmByCategory');
        
        $umkmByCategory = $response->viewData('umkmByCategory');
        expect($umkmByCategory)->toHaveCount(2);
    });
    
    test('dashboard displays UMKM by district distribution', function () {
        $superAdmin = User::factory()->superAdmin()->create();
        $user1 = User::factory()->umkm()->create();
        $user2 = User::factory()->umkm()->create();
        $category = Category::factory()->create();
        $district1 = District::factory()->create(['nama_kecamatan' => 'District A']);
        $district2 = District::factory()->create(['nama_kecamatan' => 'District B']);
        
        UmkmProfile::create([
            'user_id' => $user1->id,
            'nama_usaha' => 'Business A',
            'slug' => 'business-a',
            'kategori_id' => $category->id,
            'kecamatan_id' => $district1->id,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => true,
        ]);
        
        UmkmProfile::create([
            'user_id' => $user2->id,
            'nama_usaha' => 'Business B',
            'slug' => 'business-b',
            'kategori_id' => $category->id,
            'kecamatan_id' => $district2->id,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => true,
        ]);
        
        $response = $this->actingAs($superAdmin)->get(route('superadmin.dashboard'));
        
        $response->assertOk();
        $response->assertViewHas('umkmByDistrict');
        
        $umkmByDistrict = $response->viewData('umkmByDistrict');
        expect($umkmByDistrict)->toHaveCount(2);
    });
    
    test('dashboard displays user growth data', function () {
        $superAdmin = User::factory()->superAdmin()->create();
        
        // Create users from different days
        User::factory()->umkm()->create(['created_at' => now()->subDays(5)]);
        User::factory()->umkm()->create(['created_at' => now()->subDays(3)]);
        User::factory()->umkm()->create(['created_at' => now()->subDays(1)]);
        
        $response = $this->actingAs($superAdmin)->get(route('superadmin.dashboard'));
        
        $response->assertOk();
        $response->assertViewHas('userGrowth');
        
        $userGrowth = $response->viewData('userGrowth');
        expect($userGrowth)->not->toBeEmpty();
    });
    
    test('dashboard shows published vs unpublished UMKM', function () {
        $superAdmin = User::factory()->superAdmin()->create();
        $user1 = User::factory()->umkm()->create();
        $user2 = User::factory()->umkm()->create();
        $category = Category::factory()->create();
        $district = District::factory()->create();
        
        // Published profile
        UmkmProfile::create([
            'user_id' => $user1->id,
            'nama_usaha' => 'Published Business',
            'slug' => 'published-business',
            'kategori_id' => $category->id,
            'kecamatan_id' => $district->id,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => true,
        ]);
        
        // Unpublished profile
        UmkmProfile::create([
            'user_id' => $user2->id,
            'nama_usaha' => 'Unpublished Business',
            'slug' => 'unpublished-business',
            'kategori_id' => $category->id,
            'kecamatan_id' => $district->id,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => false,
        ]);
        
        $response = $this->actingAs($superAdmin)->get(route('superadmin.dashboard'));
        
        $response->assertOk();
        $stats = $response->viewData('stats');
        
        expect($stats['total_umkm'])->toBe(2);
        expect($stats['published_umkm'])->toBe(1);
    });
    
    test('admin cannot access superadmin dashboard', function () {
        $admin = User::factory()->admin()->create();
        
        $response = $this->actingAs($admin)->get(route('superadmin.dashboard'));
        
        $response->assertForbidden();
    });
    
    test('UMKM cannot access superadmin dashboard', function () {
        $umkm = User::factory()->umkm()->create();
        
        $response = $this->actingAs($umkm)->get(route('superadmin.dashboard'));
        
        $response->assertForbidden();
    });
    
    test('guest cannot access superadmin dashboard', function () {
        $response = $this->get(route('superadmin.dashboard'));
        
        $response->assertRedirect(route('login'));
    });
});
