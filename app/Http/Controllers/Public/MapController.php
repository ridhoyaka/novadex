<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\District;
use App\Models\UmkmProfile;

class MapController extends Controller
{
    public function index()
    {
        $umkmList = UmkmProfile::with(['category', 'district', 'user'])
            ->where('is_published', true)
            ->get();

        $categories = Category::withCount('umkmProfiles')->get();
        $districts = District::withCount('umkmProfiles')->get();

        return view('public.map', compact('umkmList', 'categories', 'districts'));
    }
}
