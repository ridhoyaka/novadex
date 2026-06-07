<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\District;
use App\Models\ProfileFlag;
use App\Models\UmkmProfile;
use App\Services\ProfileCompletionService;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $query = UmkmProfile::with(['category', 'district', 'user'])
            ->withCount([
                'flags as active_flags_count' => function ($query) {
                    $query->where('status', 'active');
                }
            ]);

        if ($request->filled('category')) {
            $query->where('kategori_id', $request->category);
        }

        if ($request->filled('district')) {
            $query->where('kecamatan_id', $request->district);
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        if ($request->filled('search')) {
            $query->where('nama_usaha', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('quality')) {
            $this->applyQualityFilter($query, $request->quality);
        }

        $profiles = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::all();
        $districts = District::all();
        $stats = [
            'total' => UmkmProfile::count(),
            'published' => UmkmProfile::where('is_published', true)->count(),
            'no_photo' => $this->noPhotoQuery(UmkmProfile::query())->count(),
            'short_desc' => UmkmProfile::whereRaw('LENGTH(deskripsi) < 50')->count(),
            'no_location' => UmkmProfile::where(function ($query) {
                $query->whereNull('latitude')->orWhereNull('longitude');
            })->count(),
            'low_completion' => UmkmProfile::where('profile_completion_score', '<', 50)->count(),
            'active_flags' => ProfileFlag::where('status', 'active')->count(),
        ];

        return view('admin.content.index', compact('profiles', 'categories', 'districts', 'stats'));
    }

    public function show(UmkmProfile $profile, ProfileCompletionService $completionService)
    {
        $profile->load([
            'category',
            'district',
            'user',
            'flags' => function ($query) {
                $query->with('admin')->latest();
            },
        ]);
        $missingFields = $completionService->getMissingFields($profile);

        return view('admin.content.show', compact('profile', 'missingFields'));
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

    private function applyQualityFilter($query, string $quality): void
    {
        switch ($quality) {
            case 'no_photo':
                $this->noPhotoQuery($query);
                break;
            case 'short_desc':
                $query->whereRaw('LENGTH(deskripsi) < 50');
                break;
            case 'no_location':
                $query->where(function ($query) {
                    $query->whereNull('latitude')->orWhereNull('longitude');
                });
                break;
            case 'low_completion':
                $query->where('profile_completion_score', '<', 50);
                break;
            case 'flagged':
                $query->whereHas('flags', function ($query) {
                    $query->where('status', 'active');
                });
                break;
        }
    }

    private function noPhotoQuery($query)
    {
        return $query->whereNull('logo_path')
            ->where(function ($query) {
                $query->whereNull('photos')->orWhereJsonLength('photos', 0);
            });
    }
}
