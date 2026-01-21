<?php

namespace App\Listeners;

use App\Enums\ApplicantStatus;
use App\Events\ApplicantStatusChanged;
use App\Models\PhotographerProfile;
use App\Models\User;
use App\Notifications\Photographer\ApplicantRejected;
use App\Notifications\Photographer\PhotographerWelcome;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class HandleApplicantStatusChange implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(ApplicantStatusChanged $event): void
    {
        $applicant = $event->applicant;
        $newStatus = $event->newStatus;

        match ($newStatus) {
            ApplicantStatus::Hired->value => $this->handleHired($applicant),
            ApplicantStatus::Rejected->value => $this->handleRejected($applicant),
            default => null,
        };
    }

    /**
     * Handle when applicant is hired.
     */
    protected function handleHired($applicant): void
    {
        DB::transaction(function () use ($applicant) {
            // Create user account
            $user = User::create([
                'name' => $applicant->fullname,
                'email' => $applicant->email,
                'phone_number' => $applicant->phonenumber,
                'password' => bcrypt(Str::random(32)), // Random password
                'email_verified_at' => now(), // Auto verify since admin approved
            ]);

            // Assign photographer role
            $user->assignRole('photographer');

            // Create photographer profile
            PhotographerProfile::create([
                'user_id' => $user->id,
                'cameras' => $applicant->cameras,
                'instagram_link' => $applicant->instagram_link,
                'portofolio_link' => $applicant->portofolio_link,
                'moments' => $applicant->moments,
                'cities' => $applicant->cities,
                'is_active' => true,
            ]);

            // Create default availability schedule (Mon-Sun 08:00-20:00)
            $user->createSchedule()
                ->availability()
                ->from(now())
                ->to(now()->addYear()) // 1 year availability
                ->named('Default Availability')
                ->description('Default working hours')
                ->weekly([
                    \Carbon\Carbon::MONDAY,
                    \Carbon\Carbon::TUESDAY,
                    \Carbon\Carbon::WEDNESDAY,
                    \Carbon\Carbon::THURSDAY,
                    \Carbon\Carbon::FRIDAY,
                    \Carbon\Carbon::SATURDAY,
                    \Carbon\Carbon::SUNDAY,
                ])
                ->addPeriod('08:00', '20:00')
                ->save();

            // Send welcome notification with password reset link
            $user->notify(new PhotographerWelcome());
        });
    }

    /**
     * Handle when applicant is rejected.
     */
    protected function handleRejected($applicant): void
    {
        // Send rejection notification to applicant email
        Notification::route('mail', $applicant->email)
            ->notify(new ApplicantRejected($applicant));
    }
}
