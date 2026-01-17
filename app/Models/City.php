<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class City extends Model implements HasMedia
{
    use InteractsWithMedia, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'details',
        'price',
    ];

    /**
     * Get the packages available in this city.
     */
    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'city_package')
            ->withPivot('price')
            ->withTimestamps();
    }

    protected static function booted(): void
    {
        static::creating(function (City $city) {
            $city->slug = Str::slug($city->name, '-');
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('albums')
            ->useFallbackUrl('/images/default-city.jpg')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('photospots')
            ->useFallbackUrl('/images/default-spot.jpg')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }
}
