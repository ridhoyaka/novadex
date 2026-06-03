<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::withCount('umkmProfiles')->get();
        return view('superadmin.districts.index', compact('districts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kecamatan' => 'required|string|max:100|unique:districts',
        ]);

        District::create($validated);

        return back()->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    public function update(Request $request, District $district)
    {
        $validated = $request->validate([
            'nama_kecamatan' => 'required|string|max:100|unique:districts,nama_kecamatan,' . $district->id,
        ]);

        $district->update($validated);

        return back()->with('success', 'Kecamatan berhasil diupdate.');
    }

    public function destroy(District $district)
    {
        if ($district->umkmProfiles()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kecamatan yang masih memiliki UMKM.');
        }

        $district->delete();

        return back()->with('success', 'Kecamatan berhasil dihapus.');
    }
}
