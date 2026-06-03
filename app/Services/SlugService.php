<?php

namespace App\Services;

use Illuminate\Support\Str;

class SlugService
{
    /**
     * Generate unique slug from text
     */
    public function generateUniqueSlug(string $text, string $model, ?int $excludeId = null): string
    {
        $slug = Str::slug($text);
        $originalSlug = $slug;
        $counter = 1;
        
        while ($this->slugExists($slug, $model, $excludeId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    /**
     * Check if slug exists
     */
    protected function slugExists(string $slug, string $model, ?int $excludeId = null): bool
    {
        $query = $model::where('slug', $slug);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }
}
