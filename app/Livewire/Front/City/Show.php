<?php

namespace App\Livewire\Front\City;

use App\Models\City;
use App\Models\Moment;
use Livewire\Component;
use Livewire\Attributes\Computed;

class Show extends Component
{
    public City $city;
    public ?string $selectedMoment = null;

    public function mount(City $city)
    {
        $this->city = $city;
    }

    #[Computed]
    public function moments()
    {
        return Moment::select('id', 'name', 'slug')
            ->orderBy('name')
            ->get();
    }

    public function reserve()
    {
        return redirect()->route('reserve', ['city' => $this->city->slug, 'moment' => $this->selectedMoment]);
    }

    public function render()
    {
        return view('livewire.front.city.show');
    }
}
