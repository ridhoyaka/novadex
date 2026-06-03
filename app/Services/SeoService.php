<?php

namespace App\Services;

use App\Models\UmkmProfile;

class SeoService
{
    public function generateMetadata(UmkmProfile $profile): array
    {
        $title = $this->generateTitle($profile);
        $description = $this->generateDescription($profile);
        
        return [
            'seo_title' => $title,
            'seo_description' => $description,
        ];
    }
    
    public function generateTitle(UmkmProfile $profile): string
    {
        $parts = [
            $profile->nama_usaha,
            $profile->category->nama_kategori ?? '',
            'di ' . ($profile->district->nama_kecamatan ?? 'Salatiga'),
        ];
        
        $title = implode(' - ', array_filter($parts));
        
        // Add suffix
        $title .= ' | NovaDex';
        
        // Limit to 60 characters for SEO
        if (strlen($title) > 60) {
            $title = substr($title, 0, 57) . '...';
        }
        
        return $title;
    }
    
    public function generateDescription(UmkmProfile $profile): string
    {
        $description = strip_tags($profile->deskripsi);
        
        // Limit to 155 characters for SEO
        if (strlen($description) > 155) {
            $description = substr($description, 0, 152) . '...';
        }
        
        return $description;
    }
    
    public function generateStructuredData(UmkmProfile $profile): array
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => $profile->nama_usaha,
            'description' => $profile->deskripsi,
            'telephone' => $profile->whatsapp,
        ];
        
        // Add URL if possible
        try {
            if (function_exists('route')) {
                $data['url'] = route('umkm.show', $profile->slug);
            }
        } catch (\Exception $e) {
            // Skip if route helper not available
        }
        
        // Add address if available
        if ($profile->latitude && $profile->longitude) {
            $data['address'] = [
                '@type' => 'PostalAddress',
                'addressLocality' => $profile->district->nama_kecamatan ?? 'Salatiga',
                'addressRegion' => 'Jawa Tengah',
                'addressCountry' => 'ID',
            ];
            
            $data['geo'] = [
                '@type' => 'GeoCoordinates',
                'latitude' => $profile->latitude,
                'longitude' => $profile->longitude,
            ];
        }
        
        // Add image if available
        if ($profile->logo_path) {
            try {
                if (function_exists('asset')) {
                    $data['image'] = asset('storage/' . $profile->logo_path);
                }
            } catch (\Exception $e) {
                // Fallback to relative path
                $data['image'] = '/storage/' . $profile->logo_path;
            }
        }
        
        return $data;
    }
    
    public function generateAltText(UmkmProfile $profile, string $type = 'logo', int $index = null): string
    {
        $base = $profile->nama_usaha;
        
        switch ($type) {
            case 'logo':
                return "{$base} - Logo";
            case 'photo':
                return "{$base} - Foto " . ($index + 1);
            default:
                return $base;
        }
    }
    
    /**
     * Generate placeholder icon based on category or initial
     */
    public function generatePlaceholder(UmkmProfile $profile): string
    {
        // Category-based emojis
        $categoryEmojis = [
            'Kuliner' => '🍽️',
            'Fashion' => '👕',
            'Kerajinan' => '🎨',
            'Jasa' => '🔧',
            'Teknologi' => '💻',
            'Pendidikan' => '📚',
            'Kesehatan' => '🏥',
            'Pertanian' => '🌾',
            'Otomotif' => '🚗',
            'Properti' => '🏠',
        ];
        
        // Try to match category
        $categoryName = $profile->category->nama_kategori ?? '';
        foreach ($categoryEmojis as $key => $emoji) {
            if (stripos($categoryName, $key) !== false) {
                return $emoji;
            }
        }
        
        // Fallback to initial-based
        $initial = strtoupper(substr($profile->nama_usaha, 0, 1));
        if (preg_match('/[A-Z]/', $initial)) {
            return $initial;
        }
        
        // Default fallback
        return '🏪';
    }
}
