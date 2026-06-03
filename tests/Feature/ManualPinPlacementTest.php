<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\District;
use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManualPinPlacementTest extends TestCase
{
    use RefreshDatabase;

    private User $umkmUser;
    private UmkmProfile $profile;

    protected function setUp(): void
    {
        parent::setUp();

        $category = Category::factory()->create();
        $district = District::factory()->create();

        $this->umkmUser = User::factory()->umkm()->create();
        $this->profile = UmkmProfile::factory()->for($this->umkmUser, 'user')
            ->for($category, 'category')
            ->for($district, 'district')
            ->create();
    }

    /** @test */
    public function umkm_can_click_on_map_to_place_marker()
    {
        // This is a frontend feature test - we verify the backend accepts the coordinates
        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => -7.5616,
                'longitude' => 110.5084,
                'alamat_lengkap' => 'Clicked location on map',
            ]);

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->profile->refresh();
        $this->assertEquals(-7.5616, $this->profile->latitude);
        $this->assertEquals(110.5084, $this->profile->longitude);
    }

    /** @test */
    public function umkm_can_drag_marker_to_update_location()
    {
        // Set initial location
        $this->profile->update([
            'latitude' => -7.5616,
            'longitude' => 110.5084,
        ]);

        // Drag marker to new location
        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => -7.5700,
                'longitude' => 110.5100,
                'alamat_lengkap' => 'Dragged marker location',
            ]);

        $response->assertOk();

        $this->profile->refresh();
        $this->assertEquals(-7.5700, $this->profile->latitude);
        $this->assertEquals(110.5100, $this->profile->longitude);
    }

    /** @test */
    public function marker_coordinates_are_updated_on_drag()
    {
        // Verify that dragging updates coordinates correctly
        $newLat = -7.5650;
        $newLng = 110.5090;

        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => $newLat,
                'longitude' => $newLng,
                'alamat_lengkap' => 'Dragged location',
            ]);

        $response->assertOk();

        $this->profile->refresh();
        $this->assertEquals($newLat, $this->profile->latitude);
        $this->assertEquals($newLng, $this->profile->longitude);
    }

    /** @test */
    public function current_location_button_works_with_valid_coordinates()
    {
        // Simulate user clicking "current location" button
        // This would use browser geolocation API, we test the backend accepts it
        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => -7.5616,
                'longitude' => 110.5084,
                'alamat_lengkap' => 'Current location',
            ]);

        $response->assertOk();

        $this->profile->refresh();
        $this->assertNotNull($this->profile->latitude);
        $this->assertNotNull($this->profile->longitude);
    }

    /** @test */
    public function location_outside_salatiga_is_rejected()
    {
        // Try to set location outside Salatiga bounds
        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => -6.2088, // Jakarta
                'longitude' => 106.8456,
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Koordinat di luar area Salatiga. Pastikan lokasi yang ditandai benar.',
            ]);
    }

    /** @test */
    public function map_click_creates_marker_if_none_exists()
    {
        // Ensure profile has no location initially
        $this->profile->update([
            'latitude' => null,
            'longitude' => null,
        ]);

        // Click on map to create marker
        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => -7.5616,
                'longitude' => 110.5084,
                'alamat_lengkap' => 'Map click location',
            ]);

        $response->assertOk();

        $this->profile->refresh();
        $this->assertNotNull($this->profile->latitude);
        $this->assertNotNull($this->profile->longitude);
    }

    /** @test */
    public function map_click_moves_existing_marker()
    {
        // Set initial location
        $this->profile->update([
            'latitude' => -7.5616,
            'longitude' => 110.5084,
        ]);

        // Click on different location
        $response = $this->actingAs($this->umkmUser)
            ->postJson(route('umkm.profile.location.update'), [
                'latitude' => -7.5700,
                'longitude' => 110.5100,
                'alamat_lengkap' => 'New map click location',
            ]);

        $response->assertOk();

        $this->profile->refresh();
        $this->assertEquals(-7.5700, $this->profile->latitude);
        $this->assertEquals(-7.5700, $this->profile->latitude);
        $this->assertEquals(110.5100, $this->profile->longitude);
    }
}