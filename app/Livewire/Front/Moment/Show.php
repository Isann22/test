<?php

namespace App\Livewire\Front\Moment;

use App\Models\City;
use App\Models\Moment;
use Livewire\Component;
use Livewire\Attributes\Computed;

class Show extends Component
{
    public Moment $moment;
    public ?string $selectedCity = null;

    public function mount(Moment $moment)
    {
        $this->moment = $moment;
    }

    #[Computed]
    public function cities()
    {
        return City::select('id', 'name', 'price', 'slug')
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function selectedCityData()
    {
        return $this->cities->firstWhere('slug', $this->selectedCity);
    }

    public function reserve()
    {
        return redirect()->route('reserve', ['city' => $this->selectedCity, 'moment' => $this->moment->slug]);
    }

    public function render()
    {
        return view('livewire.front.moment.show');
    }
}
