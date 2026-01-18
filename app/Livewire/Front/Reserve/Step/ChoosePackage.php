<?php

namespace App\Livewire\Front\Reserve\Step;

use App\Models\City;
use App\Models\Package;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Validation\ValidationException;
use Spatie\LivewireWizard\Components\StepComponent;

class ChoosePackage extends StepComponent
{
    #[Locked]
    public string $cityId = '';

    #[Locked]
    public string $cityName = '';

    #[Locked]
    public string $momentId = '';

    #[Locked]
    public string $momentName = '';

    public ?string $selectedPackageId = null;

    #[Locked]
    public float $price = 0;

    #[Locked]
    public int $hourDuration = 0;

    #[Locked]
    public int $editedPhotos = 0;

    #[Locked]
    public int $downloadablePhotos = 0;


    public function mount(): void
    {
        $stepState = $this->state()->forStep('choose-package');
        
        $this->cityId = $stepState['cityId'] ?? '';
        $this->cityName = $stepState['cityName'] ?? '';
        $this->momentId = $stepState['momentId'] ?? '';
        $this->momentName = $stepState['momentName'] ?? '';
        $this->selectedPackageId = $stepState['selectedPackageId'] ?? null;
        $this->price = (float) ($stepState['price'] ?? 0);
        $this->hourDuration = (int) ($stepState['hourDuration'] ?? 0);
        $this->editedPhotos = (int) ($stepState['editedPhotos'] ?? 0);
        $this->downloadablePhotos = (int) ($stepState['downloadablePhotos'] ?? 0);
    }

    protected function rules(): array
    {
        return [
            'cityId' => ['required', 'uuid', 'exists:cities,id'],
            'momentId' => ['required', 'uuid', 'exists:moments,id'],
            'cityName' => ['required', 'string'],
            'momentName' => ['required', 'string'],
            'selectedPackageId' => ['required', 'uuid', 'exists:packages,id'],
            'price' => ['required', 'numeric', 'min:1'],
        ];
    }

    #[Computed]
    public function packages()
    {
        if (empty($this->cityId)) {
            return collect();
        }

        $city = City::where('id', $this->cityId)
            ->with(['packages' => function ($query) {
                $query->select('packages.id', 'packages.name', 'packages.hour_duration', 
                               'packages.downloadable_photos', 'packages.edited_photos');
            }])
            ->first();

        return $city?->packages ?? collect();
    }

    public function selectPackage(string $packageId): void
    {
        $package = $this->packages->firstWhere('id', $packageId);

        if (!$package) {
            Toaster::error('Package not found.');
            return;
        }

        $this->selectedPackageId = $packageId;
        $this->price = (float) $package->pivot->price;
        $this->hourDuration = (int) $package->hour_duration;
        $this->editedPhotos = (int) $package->edited_photos;
        $this->downloadablePhotos = (int) $package->downloadable_photos;
    }

    public function selectAndContinue(string $packageId): void
    {
        $this->selectPackage($packageId);
        
        if ($this->selectedPackageId) {
            $this->submit();
        }
    }

    public function submit(): void
    {
        try {
            $this->validate();
            $this->nextStep();
        } catch (ValidationException $e) {
            Toaster::error('Please select a package to continue.');
            return;
        }
    }

    public function stepInfo(): array
    {
        return [
            'label' => 'Choose Package',
        ];
    }

    public function render()
    {
        return view('livewire.front.reserve.step.choose-package');
    }
}
