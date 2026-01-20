<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Settlement = 'settlement';
    case Failure = 'failure';
    case Expired = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Settlement => 'Settlement',
            self::Failure => 'Failure',
            self::Expired => 'Expired',
        };
    }
}
