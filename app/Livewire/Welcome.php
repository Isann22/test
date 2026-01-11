<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\Moment;
use Livewire\Component;

class Welcome extends Component
{
    public $moments;
    public $cities;
    public bool $showDrawer1 = false;

    public function mount()
    {
        $this->moments = Moment::select('id', 'name', 'slug')
            ->with('media')
            ->get();


        $this->cities = City::select('id', 'name', 'slug', 'price')
            ->with('media')
            ->inRandomOrder()
            ->take(4)
            ->get();
    }


    public function render()
    {

        return view('livewire.welcome')->title(config('app.name'));
    }
}
