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
        return City::select('id', 'name', 'price')
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.front.moment.show');
    }
}
