<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
        'slug',
        'icon',
    ];

    public function umkmProfiles(): HasMany
    {
        return $this->hasMany(UmkmProfile::class, 'kategori_id');
    }

    protected static function booted(): void
    {
        static::saving(function (Category $category) {
            if (empty($category->slug) || $category->isDirty('nama_kategori')) {
                $category->slug = static::uniqueSlug($category->nama_kategori, $category->id);
            }
        });
    }

    protected static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name) ?: 'kategori';
        $slug = $baseSlug;
        $counter = 1;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    public function canBeDeleted(): bool
    {
        return $this->umkmProfiles()->count() === 0;
    }
}
