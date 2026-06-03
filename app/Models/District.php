<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kecamatan',
        'latitude',
        'longitude',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    public function umkmProfiles(): HasMany
    {
        return $this->hasMany(UmkmProfile::class, 'kecamatan_id');
    }

    public function canBeDeleted(): bool
    {
        return $this->umkmProfiles()->count() === 0;
    }
}
