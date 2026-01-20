<?php

namespace App\Enums;

enum ApplicantStatus: string
{
    case Review = 'review';
    case Hired = 'hired';
    case Rejected = 'rejected';


    public function label(): string
    {
        return match ($this) {
            self::Review => 'review',
            self::Hired => 'hired',
            self::Rejected => 'rejected',
        };
    }
}
