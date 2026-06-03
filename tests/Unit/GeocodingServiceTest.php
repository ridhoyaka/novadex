<?php

namespace Tests\Unit;

use App\Services\GeocodingService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeocodingServiceTest extends TestCase
{
    protected GeocodingService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new GeocodingService();
        Cache::flush();
    }

    /** @test */
    public function it_can_geocode_valid_address()
    {
        Http::fake([
            'nominatim.openstreetmap.org/*' => Http::response([
                [
                    'lat' => '-7.5616',
                    'lon' => '110.5084',
                    'display_name' => 'Jl. Diponegoro, Salatiga, Jawa Tengah, Indonesia',
                ]
            ], 200)
        ]);

        $result = $this->service->geocode('Jl. Diponegoro, Salatiga');

        $this->assertNotNull($result);
        $this->assertEquals(-7.5616, $result['lat']);
        $this->assertEquals(110.5084, $result['lng']);
        $this->assertArrayHasKey('display_name', $result);
    }

    /** @test */
    public function it_returns_null_for_empty_address()
    {
        $result = $this->service->geocode('');
        $this->assertNull($result);

        $result = $this->service->geocode('   ');
        $this->assertNull($result);
    }

    /** @test */
    public function it_returns_null_when_address_not_found()
    {
        Http::fake([
            'nominatim.openstreetmap.org/*' => Http::response([], 200)
        ]);

        $result = $this->service->geocode('NonexistentAddress12345');
        $this->assertNull($result);
    }

    /** @test */
    public function it_rejects_coordinates_outside_salatiga()
    {
        Http::fake([
            'nominatim.openstreetmap.org/*' => Http::response([
                [
                    'lat' => '-6.2088', // Jakarta
                    'lon' => '106.8456',
                    'display_name' => 'Jakarta, Indonesia',
                ]
            ], 200)
        ]);

        $result = $this->service->geocode('Jakarta');
        $this->assertNull($result);
    }

    /** @test */
    public function it_caches_successful_geocoding_results()
    {
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
        
        // First call - should hit API
        $result1 = $this->service->geocode($address);
        $this->assertNotNull($result1);

        // Mock API to return error - should not be called due to cache
        Http::fake([
            'nominatim.openstreetmap.org/*' => Http::response([], 500)
        ]);

        // Second call - should use cache
        $result2 = $this->service->geocode($address);
        $this->assertNotNull($result2);
        $this->assertEquals($result1, $result2);
    }

    /** @test */
    public function it_validates_coordinates_within_salatiga()
    {
        // Valid Salatiga coordinates
        $this->assertTrue($this->service->isWithinSalatiga(-7.5616, 110.5084));
        $this->assertTrue($this->service->isWithinSalatiga(-7.7, 110.4));
        
        // Invalid coordinates (outside Salatiga)
        $this->assertFalse($this->service->isWithinSalatiga(-6.2088, 106.8456)); // Jakarta
        $this->assertFalse($this->service->isWithinSalatiga(-8.0, 110.5)); // Too far south
        $this->assertFalse($this->service->isWithinSalatiga(-7.5, 111.0)); // Too far east
    }

    /** @test */
    public function it_validates_coordinate_ranges()
    {
        // Valid coordinates
        $this->assertTrue($this->service->isValidCoordinates(-7.5616, 110.5084));
        $this->assertTrue($this->service->isValidCoordinates(0, 0));
        $this->assertTrue($this->service->isValidCoordinates(-90, -180));
        $this->assertTrue($this->service->isValidCoordinates(90, 180));
        
        // Invalid coordinates
        $this->assertFalse($this->service->isValidCoordinates(-91, 110)); // Lat too low
        $this->assertFalse($this->service->isValidCoordinates(91, 110)); // Lat too high
        $this->assertFalse($this->service->isValidCoordinates(-7, -181)); // Lng too low
        $this->assertFalse($this->service->isValidCoordinates(-7, 181)); // Lng too high
    }

    /** @test */
    public function it_can_reverse_geocode_coordinates()
    {
        Http::fake([
            'nominatim.openstreetmap.org/*' => Http::response([
                'display_name' => 'Jl. Diponegoro, Salatiga, Jawa Tengah, Indonesia',
            ], 200)
        ]);

        $result = $this->service->reverseGeocode(-7.5616, 110.5084);
        
        $this->assertNotNull($result);
        $this->assertStringContainsString('Salatiga', $result);
    }

    /** @test */
    public function it_returns_null_for_invalid_coordinates_in_reverse_geocode()
    {
        $result = $this->service->reverseGeocode(100, 200); // Invalid coordinates
        $this->assertNull($result);
    }

    /** @test */
    public function it_caches_reverse_geocoding_results()
    {
        Http::fake([
            'nominatim.openstreetmap.org/*' => Http::response([
                'display_name' => 'Jl. Diponegoro, Salatiga, Jawa Tengah, Indonesia',
            ], 200)
        ]);

        // First call
        $result1 = $this->service->reverseGeocode(-7.5616, 110.5084);
        $this->assertNotNull($result1);

        // Mock error - should not be called due to cache
        Http::fake([
            'nominatim.openstreetmap.org/*' => Http::response([], 500)
        ]);

        // Second call - should use cache
        $result2 = $this->service->reverseGeocode(-7.5616, 110.5084);
        $this->assertNotNull($result2);
        $this->assertEquals($result1, $result2);
    }

    /** @test */
    public function it_can_clear_cache_for_specific_address()
    {
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
        
        // Geocode to populate cache
        $this->service->geocode($address);
        
        // Clear cache
        $result = $this->service->clearCache($address);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_handles_http_errors_gracefully()
    {
        Http::fake([
            'nominatim.openstreetmap.org/*' => Http::response([], 500)
        ]);

        $result = $this->service->geocode('Jl. Diponegoro, Salatiga');
        $this->assertNull($result);
    }

    /** @test */
    public function it_handles_network_timeouts_gracefully()
    {
        Http::fake([
            'nominatim.openstreetmap.org/*' => function () {
                throw new \Exception('Connection timeout');
            }
        ]);

        $result = $this->service->geocode('Jl. Diponegoro, Salatiga');
        $this->assertNull($result);
    }
}
