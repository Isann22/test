<?php

namespace App\Livewire;

use App\Models\City;
use Livewire\Component;

class Welcome extends Component
{
    public array $categories = [];
    public $cities;
    public bool $showDrawer1 = false;

    public function mount()
    {
        $this->categories = [
            [
                'title' => 'Holiday',
                'description' => 'Capture precious moments at your favourite destinations',
                'image' => 'https://img.freepik.com/free-photo/traveler-with-camera_23-2148037084.jpg?w=360&t=st=1704200000~exp=1704200600~hmac=xyz',
                'type' => 'standard'
            ],
            [
                'title' => 'Family',
                'description' => 'From intimate family shoots to special gatherings',
                'image' => 'https://img.freepik.com/free-vector/happy-family-illustration_1284-17248.jpg?w=360',
                'type' => 'standard'
            ],
            [
                'title' => 'Marriage',
                'links' => ['Proposal', 'Pre-wedding'], // Contoh struktur beda (sub-menu)
                'image' => 'https://img.freepik.com/free-vector/wedding-couple-flat-style_23-2147947683.jpg?w=360',
                'type' => 'links'
            ],
            [
                'title' => 'Birthday',
                'description' => 'Every birthday is worthy to be celebrated',
                'image' => 'https://img.freepik.com/free-vector/birthday-cake-with-candles_23-2147633394.jpg?w=360',
                'type' => 'standard'
            ],
            [
                'title' => 'Graduation',
                'description' => 'Celebrate your achievements',
                'image' => 'https://img.freepik.com/free-vector/graduates-wearing-medical-masks_23-2148560662.jpg?w=360',
                'type' => 'standard'
            ],
            [
                'title' => 'Baby',
                'links' => ['Maternity', 'Newborn'],
                'image' => 'https://img.freepik.com/free-vector/cute-baby-shower-elements_23-2147659560.jpg?w=360',
                'type' => 'links'
            ],
            [
                'title' => 'Others',
                'description' => 'For every moment, anywhere, any time',
                'image' => 'https://img.freepik.com/free-vector/graduates-wearing-medical-masks_23-2148560662.jpg?w=360',
                'type' => 'standard'
            ],
        ];


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
