<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\District;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    /**
     * Display UMKM list with full management
     */
    public function index(Request $request)
    {
        $query = UmkmProfile::with(['category', 'district', 'user']);

        if ($request->has('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'unpublished') {
                $query->where('is_published', false);
            }
        }

        if ($request->has('category') && $request->category) {
            $query->where('kategori_id', $request->category);
        }

        if ($request->has('district') && $request->district) {
            $query->where('kecamatan_id', $request->district);
        }

        if ($request->has('search') && $request->search) {
            $query->where('nama_usaha', 'like', '%' . $request->search . '%');
        }

        $umkmList = $query->latest()->paginate(20);
        $categories = Category::all();
        $districts = District::all();

        return view('superadmin.umkm.index', compact('umkmList', 'categories', 'districts'));
    }

    /**
     * Display UMKM detail
     */
    public function show(UmkmProfile $umkm)
    {
        $umkm->load(['category', 'district', 'user']);
        return view('superadmin.umkm.show', compact('umkm'));
    }

    /**
     * Show edit form for UMKM
     */
    public function edit(UmkmProfile $umkm)
    {
        $umkm->load(['category', 'district', 'user']);
        $categories = Category::all();
        $districts = District::all();

        return view('superadmin.umkm.edit', compact('umkm', 'categories', 'districts'));
    }

    /**
     * Update UMKM profile
     */
    public function update(Request $request, UmkmProfile $umkm)
    {
        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'kecamatan_id' => 'required|exists:districts,id',
            'deskripsi' => 'required|string|min:20',
            'whatsapp' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat_lengkap' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');

        $umkm->update($validated);

        // Recalculate profile completion
        $completionService = app(\App\Services\ProfileCompletionService::class);
        $score = $completionService->calculateScore($umkm);
        $umkm->update(['profile_completion_score' => $score]);

        // Log activity
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'superadmin_update_umkm',
            'model_type' => UmkmProfile::class,
            'model_id' => $umkm->id,
            'description' => "Super Admin updated UMKM: {$umkm->nama_usaha}",
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('superadmin.umkm.show', $umkm)
            ->with('success', 'UMKM berhasil diperbarui.');
    }

    /**
     * Delete UMKM profile
     */
    public function destroy(UmkmProfile $umkm)
    {
        $namaUsaha = $umkm->nama_usaha;

        // Log activity before deletion
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'superadmin_delete_umkm',
            'model_type' => UmkmProfile::class,
            'model_id' => $umkm->id,
            'description' => "Super Admin deleted UMKM: {$namaUsaha}",
            'ip_address' => request()->ip(),
        ]);

        $umkm->delete();

        return redirect()->route('superadmin.umkm.index')
            ->with('success', "UMKM '{$namaUsaha}' berhasil dihapus.");
    }

    /**
     * Toggle publish status
     */
    public function togglePublish(UmkmProfile $umkm)
    {
        $umkm->update(['is_published' => !$umkm->is_published]);

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'superadmin_toggle_publish',
            'model_type' => UmkmProfile::class,
            'model_id' => $umkm->id,
            'description' => "Super Admin " . ($umkm->is_published ? 'published' : 'unpublished') . " UMKM: {$umkm->nama_usaha}",
            'ip_address' => request()->ip(),
        ]);

        return redirect()->back()
            ->with('success', 'Status publikasi berhasil diubah.');
    }

    /**
     * Export UMKM data to CSV
     */
    public function export(Request $request)
    {
        $query = UmkmProfile::with(['category', 'district', 'user']);

        if ($request->has('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'unpublished') {
                $query->where('is_published', false);
            }
        }

        if ($request->has('category') && $request->category) {
            $query->where('kategori_id', $request->category);
        }

        if ($request->has('district') && $request->district) {
            $query->where('kecamatan_id', $request->district);
        }

        if ($request->has('search') && $request->search) {
            $query->where('nama_usaha', 'like', '%' . $request->search . '%');
        }

        $umkmList = $query->latest()->get();

        $filename = 'umkm-export-' . date('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($umkmList) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, [
                'Nama Usaha', 'Kategori', 'Kecamatan', 'Pemilik', 'Email Pemilik',
                'WhatsApp', 'Deskripsi', 'Alamat', 'Latitude', 'Longitude',
                'Status', 'Skor Kelengkapan', 'Tanggal Daftar'
            ]);

            foreach ($umkmList as $umkm) {
                fputcsv($file, [
                    $umkm->nama_usaha,
                    $umkm->category->nama_kategori,
                    $umkm->district->nama_kecamatan,
                    $umkm->user->name,
                    $umkm->user->email,
                    $umkm->whatsapp,
                    $umkm->deskripsi,
                    $umkm->alamat_lengkap,
                    $umkm->latitude,
                    $umkm->longitude,
                    $umkm->is_published ? 'Aktif' : 'Nonaktif',
                    $umkm->profile_completion_score . '%',
                    $umkm->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
