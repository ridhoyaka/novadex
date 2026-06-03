<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeocodingService
{
    /**
     * Nominatim API endpoint
     */
    private const NOMINATIM_URL = 'https://nominatim.openstreetmap.org/search';
    
    /**
     * Cache duration in seconds (7 days)
     */
    private const CACHE_DURATION = 604800;
    
    /**
     * Rate limit delay in seconds (Nominatim requires max 1 request per second)
     */
    private const RATE_LIMIT_DELAY = 1;
    
    /**
     * Salatiga area bounds for validation
     */
    private const SALATIGA_BOUNDS = [
        'min_lat' => -7.8,
        'max_lat' => -7.3,
        'min_lng' => 110.3,
        'max_lng' => 110.7,
    ];
    
    /**
     * Geocode an address to coordinates
     *
     * @param string $address
     * @return array|null Returns ['lat' => float, 'lng' => float, 'display_name' => string] or null
     */
    public function geocode(string $address): ?array
    {
        if (empty(trim($address))) {
            return null;
        }
        
        // Generate cache key
        $cacheKey = $this->getCacheKey($address);
        
        // Check cache first
        $cached = Cache::get($cacheKey);
        if ($cached !== null) {
            Log::info('Geocoding cache hit', ['address' => $address]);
            return $cached;
        }
        
        // Rate limiting: wait before making request
        $this->respectRateLimit();
        
        try {
            // Make request to Nominatim
            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'NovaDex-Platform/1.0 (Salatiga UMKM Directory)',
                ])
                ->get(self::NOMINATIM_URL, [
                    'format' => 'json',
                    'q' => $address . ', Salatiga, Indonesia',
                    'limit' => 1,
                    'addressdetails' => 1,
                ]);
            
            if (!$response->successful()) {
                Log::error('Geocoding API error', [
                    'status' => $response->status(),
                    'address' => $address,
                ]);
                return null;
            }
            
            $data = $response->json();
            
            if (empty($data)) {
                Log::info('Geocoding: No results found', ['address' => $address]);
                // Cache negative result for shorter duration (1 hour)
                Cache::put($cacheKey, null, 3600);
                return null;
            }
            
            $result = $data[0];
            $lat = (float) $result['lat'];
            $lng = (float) $result['lon'];
            
            // Validate coordinates are within Salatiga area
            if (!$this->isWithinSalatiga($lat, $lng)) {
                Log::warning('Geocoding: Coordinates outside Salatiga', [
                    'address' => $address,
                    'lat' => $lat,
                    'lng' => $lng,
                ]);
                // Cache this result so we don't keep trying
                Cache::put($cacheKey, null, 3600);
                return null;
            }
            
            $geocoded = [
                'lat' => $lat,
                'lng' => $lng,
                'display_name' => $result['display_name'] ?? $address,
            ];
            
            // Cache successful result
            Cache::put($cacheKey, $geocoded, self::CACHE_DURATION);
            
            Log::info('Geocoding successful', [
                'address' => $address,
                'coordinates' => [$lat, $lng],
            ]);
            
            return $geocoded;
            
        } catch (\Exception $e) {
            Log::error('Geocoding exception', [
                'address' => $address,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
    
    /**
     * Reverse geocode coordinates to address
     *
     * @param float $lat
     * @param float $lng
     * @return string|null
     */
    public function reverseGeocode(float $lat, float $lng): ?string
    {
        // Validate coordinates
        if (!$this->isValidCoordinates($lat, $lng)) {
            return null;
        }
        
        // Generate cache key
        $cacheKey = $this->getCacheKey("reverse_{$lat}_{$lng}");
        
        // Check cache first
        $cached = Cache::get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }
        
        // Rate limiting
        $this->respectRateLimit();
        
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'NovaDex-Platform/1.0 (Salatiga UMKM Directory)',
                ])
                ->get('https://nominatim.openstreetmap.org/reverse', [
                    'format' => 'json',
                    'lat' => $lat,
                    'lon' => $lng,
                    'addressdetails' => 1,
                ]);
            
            if (!$response->successful()) {
                return null;
            }
            
            $data = $response->json();
            $address = $data['display_name'] ?? null;
            
            // Cache result
            if ($address) {
                Cache::put($cacheKey, $address, self::CACHE_DURATION);
            }
            
            return $address;
            
        } catch (\Exception $e) {
            Log::error('Reverse geocoding exception', [
                'coordinates' => [$lat, $lng],
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
    
    /**
     * Validate if coordinates are within Salatiga area
     *
     * @param float $lat
     * @param float $lng
     * @return bool
     */
    public function isWithinSalatiga(float $lat, float $lng): bool
    {
        return $lat >= self::SALATIGA_BOUNDS['min_lat']
            && $lat <= self::SALATIGA_BOUNDS['max_lat']
            && $lng >= self::SALATIGA_BOUNDS['min_lng']
            && $lng <= self::SALATIGA_BOUNDS['max_lng'];
    }
    
    /**
     * Validate coordinates are within valid ranges
     *
     * @param float $lat
     * @param float $lng
     * @return bool
     */
    public function isValidCoordinates(float $lat, float $lng): bool
    {
        return $lat >= -90 && $lat <= 90 && $lng >= -180 && $lng <= 180;
    }
    
    /**
     * Generate cache key for an address
     *
     * @param string $address
     * @return string
     */
    private function getCacheKey(string $address): string
    {
        return 'geocoding:' . md5(strtolower(trim($address)));
    }
    
    /**
     * Respect rate limiting by tracking last request time
     */
    private function respectRateLimit(): void
    {
        $lastRequestKey = 'geocoding:last_request';
        $lastRequest = Cache::get($lastRequestKey, 0);
        $now = microtime(true);
        
        $timeSinceLastRequest = $now - $lastRequest;
        
        if ($timeSinceLastRequest < self::RATE_LIMIT_DELAY) {
            $sleepTime = (self::RATE_LIMIT_DELAY - $timeSinceLastRequest) * 1000000;
            usleep((int) $sleepTime);
        }
        
        Cache::put($lastRequestKey, microtime(true), 60);
    }
    
    /**
     * Clear geocoding cache for a specific address
     *
     * @param string $address
     * @return bool
     */
    public function clearCache(string $address): bool
    {
        $cacheKey = $this->getCacheKey($address);
        return Cache::forget($cacheKey);
    }
    
    /**
     * Clear all geocoding cache
     *
     * @return bool
     */
    public function clearAllCache(): bool
    {
        // This is a simple implementation
        // In production, you might want to use cache tags
        return Cache::flush();
    }
}
