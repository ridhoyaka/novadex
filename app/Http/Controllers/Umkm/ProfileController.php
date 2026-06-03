<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Http\Requests\UmkmProfileRequest;
use App\Models\Category;
use App\Models\District;
use App\Services\GeocodingService;
use App\Services\UmkmService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        private UmkmService $umkmService,
        private GeocodingService $geocodingService
    ) {
    }

    public function edit()
    {
        $profile = auth()->user()->umkmProfile;
        $categories = Category::all();
        $districts = District::all();
        
        return view('umkm.profile-form', compact('profile', 'categories', 'districts'));
    }

    public function update(UmkmProfileRequest $request)
    {
        $user = auth()->user();
        $profile = $user->umkmProfile;
        
        if ($profile) {
            $this->umkmService->updateProfile($profile, $request->validated());
        } else {
            $profile = $this->umkmService->createProfile($user, $request->validated());
        }
        
        return redirect()->route('umkm.dashboard')->with('success', 'Profil berhasil diperbarui!');
    }

    public function togglePublish()
    {
        $profile = auth()->user()->umkmProfile;
        
        if ($profile) {
            $this->umkmService->togglePublishStatus($profile);
            $status = $profile->fresh()->is_published ? 'dipublikasikan' : 'disembunyikan';
            return back()->with('success', "Profil berhasil {$status}!");
        }
        
        return back()->with('error', 'Profil tidak ditemukan!');
    }

    public function uploadLogo(Request $request)
    {
        $request->validate(['logo' => 'required|image|max:2048']);
        
        $profile = auth()->user()->umkmProfile;
        $this->umkmService->uploadLogo($profile, $request->file('logo'));
        
        return back()->with('success', 'Logo berhasil diupload!');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate(['photo' => 'required|image|max:2048']);
        
        $profile = auth()->user()->umkmProfile;
        
        try {
            $this->umkmService->uploadGalleryPhoto($profile, $request->file('photo'));
            return back()->with('success', 'Foto berhasil diupload!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function deletePhoto(Request $request)
    {
        $profile = auth()->user()->umkmProfile;
        $this->umkmService->deleteGalleryPhoto($profile, $request->photo_path);
        
        return back()->with('success', 'Foto berhasil dihapus!');
    }

    public function updateLocation(Request $request)
    {
        try {
            $validated = $request->validate([
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'alamat_lengkap' => 'nullable|string|max:255',
            ]);
            
            $profile = auth()->user()->umkmProfile;
            
            if (!$profile) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil tidak ditemukan'
                ], 404);
            }
            
            // Additional validation: Check if coordinates are within reasonable bounds for Salatiga
            $lat = floatval($validated['latitude']);
            $lng = floatval($validated['longitude']);
            
            if ($lat < -8 || $lat > -7 || $lng < 110 || $lng > 111) {
                return response()->json([
                    'success' => false,
                    'message' => 'Koordinat di luar area Salatiga. Pastikan lokasi yang ditandai benar.'
                ], 422);
            }
            
            $profile->update([
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'alamat_lengkap' => $validated['alamat_lengkap'],
            ]);
            
            // Return JSON for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Lokasi usaha berhasil diperbarui'
                ]);
            }
            
            return back()->with('success', 'Lokasi usaha berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error updating location: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan lokasi'
                ], 500);
            }
            
            return back()->with('error', 'Terjadi kesalahan saat menyimpan lokasi');
        }
    }

    public function removeLocation()
    {
        try {
            $profile = auth()->user()->umkmProfile;
            
            if (!$profile) {
                return back()->with('error', 'Profil tidak ditemukan');
            }
            
            $profile->update([
                'latitude' => null,
                'longitude' => null,
                'alamat_lengkap' => null,
            ]);
            
            return back()->with('success', 'Lokasi usaha berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Error removing location: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus lokasi');
        }
    }
    
    /**
     * Geocode an address to coordinates (API endpoint)
     */
    public function geocode(Request $request)
    {
        try {
            $validated = $request->validate([
                'address' => 'required|string|max:255',
            ]);
            
            $result = $this->geocodingService->geocode($validated['address']);
            
            if ($result === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Alamat tidak ditemukan atau di luar area Salatiga. Silakan coba dengan alamat yang lebih spesifik.',
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'latitude' => $result['lat'],
                    'longitude' => $result['lng'],
                    'display_name' => $result['display_name'],
                ],
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat tidak valid',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Geocoding API error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mencari lokasi. Silakan coba lagi.',
            ], 500);
        }
    }
    
    /**
     * Reorder gallery photos
     */
    public function reorderPhotos(Request $request)
    {
        try {
            $validated = $request->validate([
                'photos' => 'required|array',
                'photos.*' => 'required|string',
            ]);
            
            $profile = auth()->user()->umkmProfile;
            
            if (!$profile) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil tidak ditemukan'
                ], 404);
            }
            
            // Update photos order
            $profile->update([
                'photos' => $validated['photos'],
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Urutan foto berhasil diperbarui'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error reordering photos: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan urutan foto'
            ], 500);
        }
    }
}