<?php

namespace App\Models;

use App\Enums\ApplicantStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PhotographerApplicant extends Model
{
    use HasUuids;

    protected $fillable = [
        'fullname',
        'email',
        'phonenumber',
        'cameras',
        'instagram_link',
        'portofolio_link',
        'moments',
        'cities',
        'status',
    ];

    protected $casts = [
        'status' => ApplicantStatus::class,
        'cameras' => 'array',
        'moments' => 'array',
        'cities' => 'array',
    ];
}

