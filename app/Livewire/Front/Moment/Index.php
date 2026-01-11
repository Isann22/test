<?php

namespace App\Livewire\Front\Moment;

use App\Models\Moment;
use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;

#[Lazy]
class Index extends Component
{
    public $search = '';

    #[Computed]
    public function moments()
    {
        return Moment::select('id', 'name', 'slug', 'details')
            ->with('media')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(9);
    }

    public function placeholder()
    {
        return view('livewire.front.moment.placeholder');
    }

    public function render()
    {
        sleep(1);
        return view('livewire.front.moment.index');
    }
}
