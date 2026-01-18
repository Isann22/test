<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'reservation_code',
        'status',
        'package_price',
        'tax_rate',
        'tax_amount',
        'total_amount',
        'confirmed_at',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => ReservationStatus::class,
            'package_price' => 'decimal:2',
            'tax_rate' => 'decimal:4',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Reservation $reservation) {
            if (empty($reservation->reservation_code)) {
                $reservation->reservation_code = self::generateReservationCode();
            }
        });
    }

    public static function generateReservationCode(): string
    {
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(5));
        return "RSV-{$date}-{$random}";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detail(): HasOne
    {
        return $this->hasOne(ReservationDetail::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(ReservationPayment::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', ReservationStatus::Pending);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', ReservationStatus::Confirmed);
    }
}
