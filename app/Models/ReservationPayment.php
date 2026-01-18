<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationPayment extends Model
{
    use HasUuids;

    protected $fillable = [
        'reservation_id',
        'payment_status',
        'amount_paid',
        'gateway_response',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'payment_status' => PaymentStatus::class,
            'amount_paid' => 'decimal:2',
            'gateway_response' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function markAsPaid(array $gatewayResponse = []): bool
    {
        $this->payment_status = PaymentStatus::Paid;
        $this->gateway_response = $gatewayResponse;
        $this->paid_at = now();
        return $this->save();
    }
}
