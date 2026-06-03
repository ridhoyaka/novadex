<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\District;
use App\Services\UmkmService;
use Illuminate\Http\Request;

class UmkmCatalogController extends Controller
{
    public function __construct(private UmkmService $umkmService)
    {
    }

    public function index(Request $request)
    {
        $filters = [
            'category' => $request->get('category'),
            'district' => $request->get('district'),
            'search' => $request->get('search'),
            'sort' => $request->get('sort', 'newest'), // Default sort by newest
        ];
        
        $umkms = $this->umkmService->getPublicCatalog($filters);
        $categories = Category::all();
        $districts = District::all();
        
        return view('public.catalog', compact('umkms', 'categories', 'districts', 'filters'));
    }
    
    public function categories()
    {
        $categories = Category::withCount('umkmProfiles')->orderBy('nama_kategori')->get();
        
        return view('public.categories', compact('categories'));
    }
}
