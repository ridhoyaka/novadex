<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UmkmProfile;
use App\Models\Category;
use App\Models\District;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeocodingTest extends TestCase
{
    use RefreshDatabase;

    protected User $umkmUser;
    protected UmkmProfile $profile;

    protected function setUp(): void
    {
        parent::setUp();

        // Create necessary data
        $category = Category::factory()->create();
        $district = District::factory()->create();

        // Create UMKM user with profile
        $this->umkmUser = User::factory()->create(['role' => 'umkm']);
        $this->profile = UmkmProfile::factory()->create([
            'user_id' => $this->umkmUser->id,
            'kategori_id' => $category->id,
            'kecamatan_id' => $district->id,
        ]);
    }

    /** @test */
    public function umkm_can_update_location_with_valid_coordinates()
    {
        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => -7.5616,
                'longitude' => 110.5084,
                'alamat_lengkap' => 'Jl. Diponegoro No. 123, Salatiga',
            ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Lokasi usaha berhasil diperbarui'
            ]);

        $this->assertDatabaseHas('umkm_profiles', [
            'id' => $this->profile->id,
            'latitude' => -7.5616,
            'longitude' => 110.5084,
            'alamat_lengkap' => 'Jl. Diponegoro No. 123, Salatiga',
        ]);
    }

    /** @test */
    public function umkm_cannot_update_location_with_invalid_latitude()
    {
        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => 100, // Invalid: > 90
                'longitude' => 110.5084,
                'alamat_lengkap' => 'Test Address',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['latitude']);
    }

    /** @test */
    public function umkm_cannot_update_location_with_invalid_longitude()
    {
        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => -7.5616,
                'longitude' => 200, // Invalid: > 180
                'alamat_lengkap' => 'Test Address',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['longitude']);
    }

    /** @test */
    public function umkm_cannot_update_location_outside_salatiga_bounds()
    {
        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => -6.2088, // Jakarta coordinates
                'longitude' => 106.8456,
                'alamat_lengkap' => 'Jakarta',
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Koordinat di luar area Salatiga. Pastikan lokasi yang ditandai benar.'
            ]);
    }

    /** @test */
    public function umkm_can_update_location_without_address()
    {
        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => -7.5616,
                'longitude' => 110.5084,
                'alamat_lengkap' => null,
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('umkm_profiles', [
            'id' => $this->profile->id,
            'latitude' => -7.5616,
            'longitude' => 110.5084,
            'alamat_lengkap' => null,
        ]);
    }

    /** @test */
    public function umkm_can_remove_location()
    {
        // First, set a location
        $this->profile->update([
            'latitude' => -7.5616,
            'longitude' => 110.5084,
            'alamat_lengkap' => 'Test Address',
        ]);

        $response = $this->actingAs($this->umkmUser)
            ->delete(route('umkm.profile.location.remove'));

        $response->assertRedirect()
            ->assertSessionHas('success', 'Lokasi usaha berhasil dihapus');

        $this->assertDatabaseHas('umkm_profiles', [
            'id' => $this->profile->id,
            'latitude' => null,
            'longitude' => null,
            'alamat_lengkap' => null,
        ]);
    }

    /** @test */
    public function guest_cannot_update_location()
    {
        $response = $this->postJson(route('umkm.profile.location.update'), [
            'latitude' => -7.5616,
            'longitude' => 110.5084,
            'alamat_lengkap' => 'Test Address',
        ]);

        $response->assertUnauthorized();
    }

    /** @test */
    public function guest_cannot_remove_location()
    {
        $response = $this->delete(route('umkm.profile.location.remove'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function admin_cannot_update_umkm_location()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => -7.5616,
                'longitude' => 110.5084,
                'alamat_lengkap' => 'Test Address',
            ]);

        // Admin doesn't have a UMKM profile, so this should return 404
        // But the route is protected by role middleware, so it returns 403
        $response->assertStatus(403);
    }

    /** @test */
    public function location_update_requires_latitude()
    {
        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'longitude' => 110.5084,
                'alamat_lengkap' => 'Test Address',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['latitude']);
    }

    /** @test */
    public function location_update_requires_longitude()
    {
        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => -7.5616,
                'alamat_lengkap' => 'Test Address',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['longitude']);
    }

    /** @test */
    public function address_can_be_up_to_255_characters()
    {
        $longAddress = str_repeat('a', 255);

        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => -7.5616,
                'longitude' => 110.5084,
                'alamat_lengkap' => $longAddress,
            ]);

        $response->assertOk();

        $this->assertDatabaseHas('umkm_profiles', [
            'id' => $this->profile->id,
            'alamat_lengkap' => $longAddress,
        ]);
    }

    /** @test */
    public function address_cannot_exceed_255_characters()
    {
        $tooLongAddress = str_repeat('a', 256);

        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => -7.5616,
                'longitude' => 110.5084,
                'alamat_lengkap' => $tooLongAddress,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['alamat_lengkap']);
    }
}
