<?php

namespace App\Livewire\Front\City;

use App\Models\City;
use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;

#[Lazy]
class Index extends Component
{
    public $search = '';

    #[Computed]
    public function cities()
    {
        return City::select('id', 'name', 'slug', 'price')
            ->with('media')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(9);
    }

    public function placeholder()
    {
        return view('livewire.front.city.placeholder');
    }

    public function render()
    {
        sleep(3);
        return view('livewire.front.city.index');
    }
}
