<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationDetail extends Model
{
    use HasUuids;

    protected $fillable = [
        'reservation_id',
        'city_id',
        'moment_id',
        'package_id',
        'photoshoot_date',
        'photoshoot_time',
        'pax',
        'location_type',
        'location_details',
        'additional_info',
    ];

    protected function casts(): array
    {
        return [
            'photoshoot_date' => 'date',
            'pax' => 'integer',
        ];
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function moment(): BelongsTo
    {
        return $this->belongsTo(Moment::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
