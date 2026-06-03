<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\District;
use App\Models\UmkmProfile;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $query = UmkmProfile::with(['category', 'district', 'user']);

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'unpublished') {
                $query->where('is_published', false);
            }
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('kategori_id', $request->category);
        }

        // Filter by district
        if ($request->has('district') && $request->district) {
            $query->where('kecamatan_id', $request->district);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where('nama_usaha', 'like', '%' . $request->search . '%');
        }

        $umkmList = $query->latest()->paginate(20);
        $categories = Category::all();
        $districts = District::all();

        return view('admin.umkm.index', compact('umkmList', 'categories', 'districts'));
    }

    public function show(UmkmProfile $umkm)
    {
        $umkm->load(['category', 'district', 'user']);
        return view('admin.umkm.show', compact('umkm'));
    }
    
    /**
     * Show form to create UMKM (offline registration / admin assistance)
     */
    public function create()
    {
        $categories = Category::all();
        $districts = District::all();
        
        return view('admin.umkm.create', compact('categories', 'districts'));
    }
    
    /**
     * Store new UMKM (offline registration / admin assistance)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'kategori_id' => 'required|exists:categories,id',
            'kecamatan_id' => 'required|exists:districts,id',
            'deskripsi' => 'required|string|min:50',
            'whatsapp' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat_lengkap' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'logo' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
            
            // User data for offline registration
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email',
            'user_password' => 'required|string|min:8',
            'admin_note' => 'nullable|string|max:500',
        ]);
        
        try {
            \DB::beginTransaction();
            
            // Create user account
            $user = \App\Models\User::create([
                'name' => $validated['user_name'],
                'email' => $validated['user_email'],
                'password' => \Hash::make($validated['user_password']),
                'role' => 'umkm',
                'email_verified_at' => now(), // Auto-verify for offline registration
            ]);
            
            // Generate slug
            $slug = \Str::slug($validated['nama_usaha']);
            $originalSlug = $slug;
            $counter = 1;
            
            while (UmkmProfile::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            // Handle logo upload
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
            }
            
            // Create UMKM profile
            $umkm = UmkmProfile::create([
                'user_id' => $user->id,
                'nama_usaha' => $validated['nama_usaha'],
                'slug' => $slug,
                'kategori_id' => $validated['kategori_id'],
                'kecamatan_id' => $validated['kecamatan_id'],
                'deskripsi' => $validated['deskripsi'],
                'whatsapp' => $validated['whatsapp'],
                'email' => $validated['email'],
                'alamat_lengkap' => $validated['alamat_lengkap'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'logo_path' => $logoPath,
                'is_published' => $request->has('is_published') ? true : false,
            ]);
            
            // Calculate profile completion
            $completionService = app(\App\Services\ProfileCompletionService::class);
            $score = $completionService->calculateScore($umkm);
            $umkm->update(['profile_completion_score' => $score]);
            
            // Log activity with admin note
            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'admin_offline_registration',
                'description' => "Admin created UMKM offline: {$umkm->nama_usaha} for user: {$user->email}. Note: " . ($validated['admin_note'] ?? 'Pendaftaran offline'),
            ]);
            
            \DB::commit();
            
            // TODO: Send welcome email to UMKM with login credentials
            
            return redirect()->route('admin.umkm.show', $umkm)
                ->with('success', 'UMKM berhasil ditambahkan! Akun user telah dibuat dengan email: ' . $user->email);
                
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error creating offline UMKM: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan UMKM: ' . $e->getMessage());
        }
    }

    /**
     * Moderate publish status (for content moderation only)
     * Admin can unpublish inappropriate content, but should use flagging system first
     */
    public function moderatePublish(Request $request, UmkmProfile $umkm)
    {
        $validated = $request->validate([
            'action' => 'required|in:publish,unpublish',
            'reason' => 'required_if:action,unpublish|nullable|string|max:500',
        ]);
        
        $oldStatus = $umkm->is_published;
        $newStatus = $validated['action'] === 'publish';
        
        // Only proceed if status actually changes
        if ($oldStatus === $newStatus) {
            return redirect()->back()->with('info', 'Status publikasi sudah sesuai');
        }
        
        $umkm->update([
            'is_published' => $newStatus
        ]);
        
        // Log activity with reason
        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'admin_moderate_publish',
            'description' => "Admin " . ($newStatus ? 'published' : 'unpublished') . " UMKM: {$umkm->nama_usaha}. Reason: " . ($validated['reason'] ?? 'Content moderation'),
        ]);
        
        // TODO: Send notification to UMKM owner about status change
        // Especially important when unpublishing - UMKM should know why

        return redirect()->back()->with('success', 'Status publikasi berhasil diubah');
    }
    
    /**
     * Export UMKM data to CSV (privacy-safe)
     */
    public function export(Request $request)
    {
        $query = UmkmProfile::with(['category', 'district', 'user']);

        // Apply same filters as index
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

        // Generate CSV
        $filename = 'umkm-export-' . date('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($umkmList) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header
            fputcsv($file, [
                'Nama Usaha',
                'Kategori',
                'Kecamatan',
                'Pemilik',
                'Deskripsi',
                'Alamat',
                'Latitude',
                'Longitude',
                'Status',
                'Skor Kelengkapan',
                'Tanggal Daftar'
            ]);

            // Data rows
            foreach ($umkmList as $umkm) {
                fputcsv($file, [
                    $umkm->nama_usaha,
                    $umkm->category->nama_kategori,
                    $umkm->district->nama_kecamatan,
                    $umkm->user->name,
                    // WhatsApp & Email EXCLUDED for privacy
                    $umkm->deskripsi,
                    $umkm->alamat_lengkap,
                    $umkm->latitude,
                    $umkm->longitude,
                    $umkm->is_published ? 'Aktif' : 'Nonaktif',
                    $umkm->profile_completion_score . '%',
                    $umkm->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            // Add privacy disclaimer
            fputcsv($file, []);
            fputcsv($file, ['CATATAN PRIVASI:']);
            fputcsv($file, ['Data kontak (WhatsApp & Email) tidak disertakan dalam export untuk menjaga privasi UMKM.']);
            fputcsv($file, ['Untuk menghubungi UMKM, gunakan halaman publik atau sistem flagging.']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
