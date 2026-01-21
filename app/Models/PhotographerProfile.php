<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhotographerProfile extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'cameras',
        'instagram_link',
        'portofolio_link',
        'moments',
        'cities',
        'is_active',
        'rating',
    ];

    protected $casts = [
        'cameras' => 'array',
        'moments' => 'array',
        'cities' => 'array',
        'is_active' => 'boolean',
        'rating' => 'decimal:2',
    ];

    /**
     * Get the user that owns this photographer profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
