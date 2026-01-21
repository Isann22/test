<?php


namespace App\Livewire\Photographer;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class PhotographerDashboard extends Component
{


    public function render()
    {
        return view('livewire.photographer.photographer-dashboard');
    }
}
