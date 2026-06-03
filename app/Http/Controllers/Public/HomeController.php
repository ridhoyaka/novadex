<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\UmkmProfile;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCategories = Category::withCount('umkmProfiles')->take(6)->get();

        $newestUmkm = UmkmProfile::with(['category', 'district'])
            ->published()
            ->latest()
            ->take(6)
            ->get();

        $totalUmkm = UmkmProfile::published()->count();
        $totalCategories = Category::count();

        return view('public.home', compact(
            'featuredCategories',
            'newestUmkm',
            'totalUmkm',
            'totalCategories'
        ));
    }
}