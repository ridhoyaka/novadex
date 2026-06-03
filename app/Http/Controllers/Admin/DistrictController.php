<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::withCount('umkmProfiles')->get();
        return view('admin.districts.index', compact('districts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255|unique:districts,nama_kecamatan',
        ]);

        District::create($request->only('nama_kecamatan'));

        return redirect()->route('admin.districts.index')->with('success', 'Kecamatan berhasil ditambahkan');
    }

    public function update(Request $request, District $district)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255|unique:districts,nama_kecamatan,' . $district->id,
        ]);

        $district->update($request->only('nama_kecamatan'));

        return redirect()->route('admin.districts.index')->with('success', 'Kecamatan berhasil diperbarui');
    }

    public function destroy(District $district)
    {
        if ($district->umkmProfiles()->count() > 0) {
            return redirect()->back()->with('error', 'Kecamatan tidak dapat dihapus karena masih digunakan oleh UMKM');
        }

        $district->delete();

        return redirect()->route('admin.districts.index')->with('success', 'Kecamatan berhasil dihapus');
    }
}
