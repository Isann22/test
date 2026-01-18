<?php

namespace App\Livewire\Reserved;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('My Reservations')]
class Index extends Component
{
    use WithPagination;

    public string $statusFilter = '';

    #[Computed]
    public function reservations()
    {
        return Reservation::where('user_id', Auth::id())
            ->with(['detail.city', 'detail.moment', 'detail.package', 'payment'])
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.reserved.index');
    }
}
