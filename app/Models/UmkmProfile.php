<?php

namespace App\Models;

use App\Observers\UmkmProfileObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([UmkmProfileObserver::class])]
class UmkmProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_usaha',
        'slug',
        'kategori_id',
        'kecamatan_id',
        'deskripsi',
        'whatsapp',
        'logo_path',
        'photos',
        'is_published',
        'latitude',
        'longitude',
        'alamat_lengkap',
        'seo_title',
        'seo_description',
        'profile_completion_score',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'photos' => 'array',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'profile_completion_score' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'kecamatan_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('kategori_id', $categoryId);
    }

    public function scopeByDistrict($query, $districtId)
    {
        return $query->where('kecamatan_id', $districtId);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('nama_usaha', 'like', "%{$term}%")
              ->orWhere('deskripsi', 'like', "%{$term}%");
        });
    }

    public function getPublicUrlAttribute(): string
    {
        return route('umkm.show', $this->slug);
    }

    public function getWhatsappLinkAttribute(): string
    {
        $number = preg_replace('/[^0-9]/', '', $this->whatsapp);
        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        }
        return "https://wa.me/{$number}";
    }

    public function getProfileCompletionAttribute(): int
    {
        $fields = [
            'nama_usaha',
            'kategori_id',
            'kecamatan_id',
            'deskripsi',
            'whatsapp',
            'logo_path',
        ];

        $completed = 0;
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $completed++;
            }
        }

        if (!empty($this->photos) && count($this->photos) > 0) {
            $completed++;
        }

        return (int) (($completed / 7) * 100);
    }

    public function flags()
    {
        return $this->hasMany(ProfileFlag::class);
    }
    
    public function hasLocation(): bool
    {
        return !empty($this->latitude) && !empty($this->longitude);
    }
    
    public function getGoogleMapsLinkAttribute(): string
    {
        if (!$this->hasLocation()) {
            return '';
        }
        return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
    }
}
