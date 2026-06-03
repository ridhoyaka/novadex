<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\UmkmProfile;

class UmkmDetailController extends Controller
{
    public function show(string $slug)
    {
        $umkm = UmkmProfile::with(['category', 'district'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        
        // Get related UMKM (same category, different UMKM, published)
        $relatedUmkm = UmkmProfile::with(['category', 'district'])
            ->where('kategori_id', $umkm->kategori_id)
            ->where('id', '!=', $umkm->id)
            ->where('is_published', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();
        
        // If not enough related by category, get from same district
        if ($relatedUmkm->count() < 3) {
            $nearbyUmkm = UmkmProfile::with(['category', 'district'])
                ->where('kecamatan_id', $umkm->kecamatan_id)
                ->where('id', '!=', $umkm->id)
                ->where('is_published', true)
                ->whereNotIn('id', $relatedUmkm->pluck('id'))
                ->inRandomOrder()
                ->limit(3 - $relatedUmkm->count())
                ->get();
            
            $relatedUmkm = $relatedUmkm->merge($nearbyUmkm);
        }
        
        return view('public.detail', compact('umkm', 'relatedUmkm'));
    }
}
