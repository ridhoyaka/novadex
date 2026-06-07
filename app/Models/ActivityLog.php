<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Schema;

class ActivityLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'model_type',
        'model_id',
        'changes',
        'ip_address',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'changes' => 'array',
            'created_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (ActivityLog $log) {
            $log->created_at ??= now();

            if (empty($log->model_type)) {
                $log->model_type = 'system';
            }

            if (empty($log->model_id)) {
                $log->model_id = 0;
            }

            if (array_key_exists('description', $log->attributes) && ! Schema::hasColumn($log->getTable(), 'description')) {
                unset($log->attributes['description']);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): MorphTo
    {
        return $this->morphTo('model');
    }
}
