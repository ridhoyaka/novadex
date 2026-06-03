<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UmkmProfile;
use App\Models\Category;
use App\Models\District;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Aggregate Statistics
        $totalUmkm = UmkmProfile::count();
        $publishedUmkm = UmkmProfile::where('is_published', true)->count();
        $avgCompletionScore = UmkmProfile::avg('profile_completion_score') ?? 0;
        
        $stats = [
            'total_users' => User::count(),
            'umkm_users' => User::where('role', 'umkm')->count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'total_umkm' => $totalUmkm,
            'published_umkm' => $publishedUmkm,
            'unpublished_umkm' => $totalUmkm - $publishedUmkm,
            'published_rate' => $totalUmkm > 0 ? round(($publishedUmkm / $totalUmkm) * 100, 1) : 0,
            'avg_completion_score' => round($avgCompletionScore, 1),
            'total_categories' => Category::count(),
            'total_districts' => District::count(),
        ];

        // UMKM Growth Trend (last 12 months) - with fallback for empty data
        $umkmGrowth = UmkmProfile::where('created_at', '>=', now()->subMonths(12))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // If no data, create empty array
        if ($umkmGrowth->isEmpty()) {
            $umkmGrowth = collect([]);
        }

        // New UMKM per Month (last 6 months)
        $newUmkmPerMonth = UmkmProfile::where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        if ($newUmkmPerMonth->isEmpty()) {
            $newUmkmPerMonth = collect([]);
        }

        // UMKM by Category Distribution
        $umkmByCategory = UmkmProfile::join('categories', 'umkm_profiles.kategori_id', '=', 'categories.id')
            ->select('categories.nama_kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('categories.id', 'categories.nama_kategori')
            ->orderBy('total', 'desc')
            ->get();

        // UMKM by District Distribution
        $umkmByDistrict = UmkmProfile::join('districts', 'umkm_profiles.kecamatan_id', '=', 'districts.id')
            ->select('districts.nama_kecamatan', DB::raw('COUNT(*) as total'))
            ->groupBy('districts.id', 'districts.nama_kecamatan')
            ->orderBy('total', 'desc')
            ->get();

        // Published vs Unpublished Comparison
        $publishedComparison = [
            'published' => $publishedUmkm,
            'unpublished' => $totalUmkm - $publishedUmkm,
        ];

        // Data Quality Metrics
        $dataQuality = [
            'with_photos' => UmkmProfile::whereNotNull('photos')->where('photos', '!=', '[]')->count(),
            'with_location' => UmkmProfile::whereNotNull('latitude')->whereNotNull('longitude')->count(),
            'complete_profiles' => UmkmProfile::where('profile_completion_score', '>=', 80)->count(),
        ];

        return view('superadmin.dashboard', compact(
            'stats',
            'umkmGrowth',
            'newUmkmPerMonth',
            'umkmByCategory',
            'umkmByDistrict',
            'publishedComparison',
            'dataQuality'
        ));
    }
}
