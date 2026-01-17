<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'hour_duration',
        'downloadable_photos',
        'edited_photos',
    ];

    /**
     * Get the cities that have this package.
     */
    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'city_package')
            ->withPivot('price')
            ->withTimestamps();
    }
}
