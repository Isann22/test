<?php

namespace App\Livewire\Front\City;

use App\Models\City;
use Livewire\Component;

class Show extends Component
{
    public City $city;


    public function mount(City $city)
    {
        $this->city = $city;
    }

    public function render()
    {
        return view('livewire.front.city.show');
    }
}
