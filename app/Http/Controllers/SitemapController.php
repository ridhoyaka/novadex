<?php

namespace App\Http\Controllers;

use App\Models\UmkmProfile;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * Generate XML sitemap
     */
    public function index()
    {
        // Cache sitemap for 1 day
        $sitemap = Cache::remember('sitemap', 86400, function () {
            return $this->generateSitemap();
        });
        
        return response($sitemap)
            ->header('Content-Type', 'text/xml');
    }
    
    /**
     * Generate sitemap content
     */
    protected function generateSitemap(): string
    {
        $profiles = UmkmProfile::where('is_published', true)
            ->orderBy('updated_at', 'desc')
            ->get();
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        // Homepage
        $xml .= '<url>';
        $xml .= '<loc>' . url('/') . '</loc>';
        $xml .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>1.0</priority>';
        $xml .= '</url>';
        
        // Catalog
        $xml .= '<url>';
        $xml .= '<loc>' . route('umkm.index') . '</loc>';
        $xml .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>daily</changefreq>';
        $xml .= '<priority>0.9</priority>';
        $xml .= '</url>';
        
        // UMKM Profiles
        foreach ($profiles as $profile) {
            $xml .= '<url>';
            $xml .= '<loc>' . route('umkm.show', $profile->slug) . '</loc>';
            $xml .= '<lastmod>' . $profile->updated_at->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }
        
        $xml .= '</urlset>';
        
        return $xml;
    }
}
