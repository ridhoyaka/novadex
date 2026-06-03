<?php

namespace App\Observers;

use App\Models\UmkmProfile;
use App\Services\SeoService;

class UmkmProfileObserver
{
    protected $seoService;
    
    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }
    
    /**
     * Handle the UmkmProfile "saving" event.
     * This runs before created and updated events.
     */
    public function saving(UmkmProfile $umkmProfile): void
    {
        // Auto-generate SEO metadata if relevant fields changed
        if ($this->shouldRegenerateSeo($umkmProfile)) {
            // Load or reload relations if needed
            if ($umkmProfile->kategori_id) {
                // Force reload if kategori_id changed
                if ($umkmProfile->isDirty('kategori_id')) {
                    $umkmProfile->unsetRelation('category');
                }
                if (!$umkmProfile->relationLoaded('category')) {
                    $umkmProfile->load('category');
                }
            }
            
            if ($umkmProfile->kecamatan_id) {
                // Force reload if kecamatan_id changed
                if ($umkmProfile->isDirty('kecamatan_id')) {
                    $umkmProfile->unsetRelation('district');
                }
                if (!$umkmProfile->relationLoaded('district')) {
                    $umkmProfile->load('district');
                }
            }
            
            $metadata = $this->seoService->generateMetadata($umkmProfile);
            $umkmProfile->seo_title = $metadata['seo_title'];
            $umkmProfile->seo_description = $metadata['seo_description'];
        }
    }
    
    /**
     * Determine if SEO should be regenerated
     */
    protected function shouldRegenerateSeo(UmkmProfile $umkmProfile): bool
    {
        // Always generate for new profiles
        if (!$umkmProfile->exists) {
            return true;
        }
        
        // Regenerate if relevant fields changed
        $relevantFields = [
            'nama_usaha',
            'kategori_id',
            'kecamatan_id',
            'deskripsi',
        ];
        
        foreach ($relevantFields as $field) {
            if ($umkmProfile->isDirty($field)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Handle the UmkmProfile "created" event.
     */
    public function created(UmkmProfile $umkmProfile): void
    {
        //
    }

    /**
     * Handle the UmkmProfile "updated" event.
     */
    public function updated(UmkmProfile $umkmProfile): void
    {
        //
    }

    /**
     * Handle the UmkmProfile "deleted" event.
     */
    public function deleted(UmkmProfile $umkmProfile): void
    {
        //
    }

    /**
     * Handle the UmkmProfile "restored" event.
     */
    public function restored(UmkmProfile $umkmProfile): void
    {
        //
    }

    /**
     * Handle the UmkmProfile "force deleted" event.
     */
    public function forceDeleted(UmkmProfile $umkmProfile): void
    {
        //
    }
}
