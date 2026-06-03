<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\District;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $query = UmkmProfile::with(['category', 'district', 'user'])
            ->where('is_published', true);
        
        // Filters
        if ($request->filled('category')) {
            $query->where('kategori_id', $request->category);
        }
        
        if ($request->filled('district')) {
            $query->where('kecamatan_id', $request->district);
        }
        
        if ($request->filled('quality')) {
            switch ($request->quality) {
                case 'no_photo':
                    $query->whereNull('logo_path')->whereJsonLength('photos', 0);
                    break;
                case 'short_desc':
                    $query->whereRaw('LENGTH(deskripsi) < 50');
                    break;
                case 'no_location':
                    $query->whereNull('latitude');
                    break;
                case 'low_completion':
                    $query->where('profile_completion_score', '<', 50);
                    break;
            }
        }
        
        $profiles = $query->paginate(20);
        $categories = Category::all();
        $districts = District::all();
        
        return view('admin.content.index', compact('profiles', 'categories', 'districts'));
    }
    
    public function show(UmkmProfile $profile)
    {
        // Read-only view
        $profile->load(['category', 'district', 'user']);
        
        // NO contact info shown (privacy)
        $profile->makeHidden(['whatsapp', 'user.email']);
        
        return view('admin.content.show', compact('profile'));
    }
    
    /**
     * Show UMKM map overview
     */
    public function map(Request $request)
    {
        // Get all UMKM with location data
        $query = UmkmProfile::with(['category', 'district'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');
        
        // Apply filters
        if ($request->filled('category')) {
            $query->where('kategori_id', $request->category);
        }
        
        if ($request->filled('district')) {
            $query->where('kecamatan_id', $request->district);
        }
        
        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }
        
        $umkmWithLocation = $query->get();
        
        // Statistics
        $stats = [
            'total_umkm' => UmkmProfile::count(),
            'with_location' => UmkmProfile::whereNotNull('latitude')->count(),
            'without_location' => UmkmProfile::whereNull('latitude')->count(),
            'published_with_location' => UmkmProfile::whereNotNull('latitude')->where('is_published', true)->count(),
        ];
        
        // Coverage by district
        $coverageByDistrict = District::withCount([
            'umkmProfiles',
            'umkmProfiles as with_location_count' => function ($query) {
                $query->whereNotNull('latitude');
            }
        ])->get();
        
        $categories = Category::all();
        $districts = District::all();
        
        return view('admin.content.map', compact('umkmWithLocation', 'stats', 'coverageByDistrict', 'categories', 'districts'));
    }
}
