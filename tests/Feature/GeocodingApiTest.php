<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UmkmProfile;
use App\Models\Category;
use App\Models\District;
use App\Services\GeocodingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeocodingApiTest extends TestCase
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
    public function umkm_can_geocode_address_via_api()
    {
        // Mock the HTTP response from Nominatim
        Http::fake([
            'nominatim.openstreetmap.org/*' => Http::response([
                [
                    'lat' => '-7.5616',
                    'lon' => '110.5084',
                    'display_name' => 'Jl. Diponegoro, Salatiga, Jawa Tengah, Indonesia',
                ]
            ], 200)
        ]);

        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.geocode'), [
                'address' => 'Jl. Diponegoro, Salatiga',
            ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'latitude' => -7.5616,
                    'longitude' => 110.5084,
                ],
            ]);
    }

    /** @test */
    public function geocode_api_requires_address()
    {
        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.geocode'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['address']);
    }

    /** @test */
    public function geocode_api_returns_error_for_address_not_found()
    {
        // Mock empty response from Nominatim
        Http::fake([
            'nominatim.openstreetmap.org/*' => Http::response([], 200)
        ]);

        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.geocode'), [
                'address' => 'NonexistentAddress12345',
            ]);

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
            ]);
    }

    /** @test */
    public function geocode_api_rejects_coordinates_outside_salatiga()
    {
        // Mock response with Jakarta coordinates
        Http::fake([
            'nominatim.openstreetmap.org/*' => Http::response([
                [
                    'lat' => '-6.2088',
                    'lon' => '106.8456',
                    'display_name' => 'Jakarta, Indonesia',
                ]
            ], 200)
        ]);

        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.geocode'), [
                'address' => 'Jakarta',
            ]);

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
            ]);
    }

    /** @test */
    public function geocode_api_uses_cache()
    {
        // First request - should hit the API
        Http::fake([
            'nominatim.openstreetmap.org/*' => Http::response([
                [
                    'lat' => '-7.5616',
                    'lon' => '110.5084',
                    'display_name' => 'Jl. Diponegoro, Salatiga, Jawa Tengah, Indonesia',
                ]
            ], 200)
        ]);

        $address = 'Jl. Diponegoro, Salatiga';
        
        $response1 = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.geocode'), ['address' => $address]);

        $response1->assertOk();

        // Second request - should use cache (no HTTP call)
        Http::fake([
            'nominatim.openstreetmap.org/*' => Http::response([], 500) // This should not be called
        ]);

        $response2 = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.geocode'), ['address' => $address]);

        $response2->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'latitude' => -7.5616,
                    'longitude' => 110.5084,
                ],
            ]);
    }

    /** @test */
    public function guest_cannot_use_geocode_api()
    {
        $response = $this->postJson(route('umkm.profile.geocode'), [
            'address' => 'Jl. Diponegoro, Salatiga',
        ]);

        $response->assertUnauthorized();
    }

    /** @test */
    public function geocode_api_handles_http_errors_gracefully()
    {
        // Mock HTTP error
        Http::fake([
            'nominatim.openstreetmap.org/*' => Http::response([], 500)
        ]);

        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.geocode'), [
                'address' => 'Jl. Diponegoro, Salatiga',
            ]);

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
            ]);
    }

    /** @test */
    public function geocode_api_validates_address_length()
    {
        $tooLongAddress = str_repeat('a', 256);

        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.geocode'), [
                'address' => $tooLongAddress,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['address']);
    }
}
