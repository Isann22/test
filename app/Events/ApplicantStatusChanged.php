<?php

namespace App\Events;

use App\Models\PhotographerApplicant;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicantStatusChanged
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public PhotographerApplicant $applicant,
        public string $newStatus
    ) {}
}
