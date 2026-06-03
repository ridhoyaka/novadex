<?php

use App\Models\Category;
use App\Models\District;
use App\Models\ProfileFlag;
use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('UMKM Dashboard Controller', function () {
    
    test('UMKM can access their dashboard', function () {
        $user = User::factory()->umkm()->create();
        $category = Category::factory()->create();
        $district = District::factory()->create();
        
        UmkmProfile::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Test Business',
            'slug' => 'test-business',
            'kategori_id' => $category->id,
            'kecamatan_id' => $district->id,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => false,
        ]);
        
        $response = $this->actingAs($user)->get(route('umkm.dashboard'));
        
        $response->assertOk();
        $response->assertViewIs('umkm.dashboard');
    });
    
    test('dashboard displays profile completion data', function () {
        $user = User::factory()->umkm()->create();
        $category = Category::factory()->create();
        $district = District::factory()->create();
        
        UmkmProfile::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Test Business',
            'slug' => 'test-business',
            'kategori_id' => $category->id,
            'kecamatan_id' => $district->id,
            'deskripsi' => str_repeat('a', 50),
            'whatsapp' => '081234567890',
            'logo_path' => 'logo.jpg',
            'is_published' => false,
        ]);
        
        $response = $this->actingAs($user)->get(route('umkm.dashboard'));
        
        $response->assertOk();
        $response->assertViewHas('completion');
        $response->assertViewHas('status');
        $response->assertViewHas('statusColor');
        $response->assertViewHas('missingFields');
        
        expect($response->viewData('completion'))->toBeInt();
        expect($response->viewData('status'))->toBeString();
    });
    
    test('dashboard displays active flags', function () {
        $user = User::factory()->umkm()->create();
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $district = District::factory()->create();
        
        $profile = UmkmProfile::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Test Business',
            'slug' => 'test-business',
            'kategori_id' => $category->id,
            'kecamatan_id' => $district->id,
            'deskripsi' => 'Test description',
            'whatsapp' => '081234567890',
            'is_published' => false,
        ]);
        
        ProfileFlag::create([
            'umkm_profile_id' => $profile->id,
            'admin_user_id' => $admin->id,
            'flag_type' => 'quality',
            'reason' => 'Needs improvement',
            'status' => 'active',
        ]);
        
        $response = $this->actingAs($user)->get(route('umkm.dashboard'));
        
        $response->assertOk();
        $response->assertViewHas('flags');
        
        $flags = $response->viewData('flags');
        expect($flags)->toHaveCount(1);
        expect($flags->first()->flag_type)->toBe('quality');
    });
    
    test('dashboard redirects if no profile exists', function () {
        $user = User::factory()->umkm()->create();
        
        $response = $this->actingAs($user)->get(route('umkm.dashboard'));
        
        $response->assertRedirect(route('umkm.profile.edit'));
        $response->assertSessionHas('info', 'Silakan lengkapi profil usaha Anda');
    });
    
    test('dashboard updates profile completion score', function () {
        $user = User::factory()->umkm()->create();
        $category = Category::factory()->create();
        $district = District::factory()->create();
        
        $profile = UmkmProfile::create([
            'user_id' => $user->id,
            'nama_usaha' => 'Test Business',
            'slug' => 'test-business',
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
        expect($profile->profile_completion_score)->toBeGreaterThan(0);
    });
    
    test('admin cannot access UMKM dashboard', function () {
        $admin = User::factory()->admin()->create();
        
        $response = $this->actingAs($admin)->get(route('umkm.dashboard'));
        
        $response->assertForbidden();
    });
    
    test('super admin cannot access UMKM dashboard', function () {
        $superAdmin = User::factory()->superAdmin()->create();
        
        $response = $this->actingAs($superAdmin)->get(route('umkm.dashboard'));
        
        $response->assertForbidden();
    });
    
    test('guest cannot access UMKM dashboard', function () {
        $response = $this->get(route('umkm.dashboard'));
        
        $response->assertRedirect(route('login'));
    });
});
