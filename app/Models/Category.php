<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function canBeDeleted(): bool
    {
        return $this->umkmProfiles()->count() === 0;
    }
}
