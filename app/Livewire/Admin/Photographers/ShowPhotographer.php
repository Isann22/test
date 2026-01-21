<?php

namespace App\Livewire\Admin\Photographers;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;

#[Layout('components.layouts.dashboard')]
class ShowPhotographer extends Component
{
    public User $photographer;

    public function mount(User $photographer): void
    {
        // Ensure this user has a photographer profile
        abort_unless($photographer->photographerProfile, 404);

        $this->photographer = $photographer->load('photographerProfile');
    }

    public function render(): View
    {
        return view('livewire.admin.photographers.show-photographer');
    }
}
