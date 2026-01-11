<?php

namespace App\Livewire\Front\PhotographerApplicant\Forms;

use Livewire\Form;

class ApplicantForm extends Form
{
    public string $fullname = '';
    public string $email = '';
    public string $phonenumber = '';
    public string $cameras = '';
    public string $instagram_link = '';
    public string $portofolio_link = '';
    public array $selectedMoments = [];
    public array $selectedCities = [];

    protected function rules(): array
    {
        return [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phonenumber' => 'required|string|max:20',
            'cameras' => 'required|string|max:500',
            'instagram_link' => 'required|url|max:255',
            'portofolio_link' => 'required|url|max:255',
            'selectedMoments' => 'required|array|min:1',
            'selectedCities' => 'required|array|min:1',
        ];
    }
}
