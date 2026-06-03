<?php

namespace App\Services;

use App\Models\UmkmProfile;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class UmkmService
{
    public function __construct(private SlugService $slugService)
    {
    }

    public function createProfile(User $user, array $data): UmkmProfile
    {
        $data['slug'] = $this->slugService->generateUniqueSlug($data['nama_usaha'], UmkmProfile::class);
        $data['user_id'] = $user->id;
        
        return UmkmProfile::create($data);
    }

    public function updateProfile(UmkmProfile $profile, array $data): UmkmProfile
    {
        // Don't regenerate slug on update (preserve existing slug)
        unset($data['slug']);
        
        $profile->update($data);
        return $profile->fresh();
    }

    public function togglePublishStatus(UmkmProfile $profile): void
    {
        $profile->update(['is_published' => !$profile->is_published]);
    }

    public function uploadLogo(UmkmProfile $profile, UploadedFile $file): string
    {
        // Delete old logo if exists
        if ($profile->logo_path) {
            Storage::disk('public')->delete($profile->logo_path);
        }
        
        $path = $file->store('umkm/logos', 'public');
        $profile->update(['logo_path' => $path]);
        
        return $path;
    }

    public function uploadGalleryPhoto(UmkmProfile $profile, UploadedFile $file): void
    {
        $photos = $profile->photos ?? [];
        
        if (count($photos) >= 3) {
            throw new \Exception('Maximum 3 photos allowed');
        }
        
        $path = $file->store('umkm/gallery', 'public');
        $photos[] = $path;
        
        $profile->update(['photos' => $photos]);
    }

    public function deleteGalleryPhoto(UmkmProfile $profile, string $photoPath): void
    {
        $photos = $profile->photos ?? [];
        $photos = array_filter($photos, fn($p) => $p !== $photoPath);
        
        Storage::disk('public')->delete($photoPath);
        $profile->update(['photos' => array_values($photos)]);
    }

    public function getPublicCatalog(array $filters = []): LengthAwarePaginator
    {
        $query = UmkmProfile::with(['category', 'district'])
            ->published();
        
        if (!empty($filters['category'])) {
            $query->byCategory($filters['category']);
        }
        
        if (!empty($filters['district'])) {
            $query->byDistrict($filters['district']);
        }
        
        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }
        
        // Apply sorting
        $sort = $filters['sort'] ?? 'newest';
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name_asc':
                $query->orderBy('nama_usaha', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('nama_usaha', 'desc');
                break;
            case 'completion':
                $query->orderBy('profile_completion_score', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }
        
        return $query->paginate(12)->appends($filters);
    }

    public function calculateProfileCompletion(UmkmProfile $profile): int
    {
        return $profile->profile_completion;
    }
}
