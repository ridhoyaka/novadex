<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\District;
use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'total_umkm' => UmkmProfile::count(),
            'published_umkm' => UmkmProfile::where('is_published', true)->count(),
            'unpublished_umkm' => UmkmProfile::where('is_published', false)->count(),
            'total_users' => User::where('role', 'umkm')->count(),
            'total_categories' => Category::count(),
            'total_districts' => District::count(),
            
            // Data quality indicators
            'without_photos' => UmkmProfile::whereNull('logo_path')
                ->where(function($q) {
                    $q->whereNull('photos')
                      ->orWhereJsonLength('photos', 0);
                })
                ->count(),
            'short_descriptions' => UmkmProfile::whereRaw('LENGTH(deskripsi) < 50')->count(),
            'without_location' => UmkmProfile::whereNull('latitude')->count(),
            'inactive_profiles' => UmkmProfile::where('updated_at', '<', now()->subDays(90))->count(),
            'low_completion' => UmkmProfile::where('profile_completion_score', '<', 50)->count(),
        ];

        // UMKM by Category
        $umkmByCategory = Category::withCount('umkmProfiles')
            ->orderBy('umkm_profiles_count', 'desc')
            ->get();

        // UMKM by District
        $umkmByDistrict = District::withCount('umkmProfiles')
            ->orderBy('umkm_profiles_count', 'desc')
            ->get();

        // Recent UMKM
        $recentUmkm = UmkmProfile::with(['category', 'district', 'user'])
            ->latest()
            ->take(10)
            ->get();

        // Recent Activity Logs
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(15)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'umkmByCategory',
            'umkmByDistrict',
            'recentUmkm',
            'recentActivities'
        ));
    }
}
