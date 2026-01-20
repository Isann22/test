<?php

namespace App\Livewire\Front\PhotographerApplicant;

use App\Livewire\Front\PhotographerApplicant\Forms\ApplicantForm;
use App\Models\City;
use App\Models\Moment;
use App\Models\PhotographerApplicant;
use Livewire\Component;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\DB;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;


class Create extends Component
{
    use WithRateLimiting;

    public ApplicantForm $form;

    public function submit(): void
    {
        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            Toaster::error("You have made too many requests. Please try again in {$exception->minutesUntilAvailable} minutes.");
            return;
        }

        $this->form->validate();

        DB::beginTransaction();
        try {
           PhotographerApplicant::create([
            'fullname' => $this->form->fullname,
            'email' => $this->form->email,
            'phonenumber' => $this->form->phonenumber,
            'cameras' => array_map('trim', explode(',', $this->form->cameras)),
            'instagram_link' => $this->form->instagram_link,
            'portofolio_link' => $this->form->portofolio_link,
            'moments' => $this->form->selectedMoments,
            'cities' => $this->form->selectedCities,
        ]);
          DB::commit();
        } catch (\Exception $e) {
          Toaster::error('an error occurred');
          DB::rollBack();
          return;
        }
       

        Toaster::success('Application submitted successfully!');

        $this->form->reset();
    }

    public function render()
    {
        return view('livewire.front.photographer-applicant.create', [
            'moments' => Moment::select('name')->get(),
            'cities' => City::select('name')->get(),
        ]);
    }
}
