<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display categories with full management capabilities
     */
    public function index()
    {
        $categories = Category::withCount('umkmProfiles')->orderBy('nama_kategori')->get();
        return view('superadmin.categories.index', compact('categories'));
    }

    /**
     * Store a new category
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,nama_kategori',
        ]);

        Category::create($request->only('nama_kategori'));

        return redirect()->route('superadmin.categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Update an existing category
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,nama_kategori,' . $category->id,
        ]);

        $category->update($request->only('nama_kategori'));

        return redirect()->route('superadmin.categories.index')->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Delete a category
     */
    public function destroy(Category $category)
    {
        if ($category->umkmProfiles()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh UMKM');
        }

        $category->delete();

        return redirect()->route('superadmin.categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}
