<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class Moment extends Model implements HasMedia
{
    use InteractsWithMedia, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'details',
    ];

    protected static function booted(): void
    {
        static::creating(function (Moment $moment) {
            $moment->slug = Str::slug($moment->name, '-');
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('albums')
            ->useFallbackUrl('/images/default-moment.jpg')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }
}
