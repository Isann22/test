<?php

namespace App\Livewire\Admin\Reservations;

use App\Models\Reservation;
use App\Enums\ReservationStatus;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

#[Layout('components.layouts.dashboard')]
class ShowReservation extends Component implements HasForms
{
    use InteractsWithForms;

    public Reservation $reservation;
    public ?string $status = null;

    public function mount(Reservation $reservation): void
    {
        $this->reservation = $reservation->load([
            'user',
            'detail.city',
            'detail.moment',
            'detail.package',
            'payment'
        ]);
        
        $this->status = $this->reservation->status->value;
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Select::make('status')
                    ->label('Update Status')
                    ->options([
                        ReservationStatus::InProgress->value => ReservationStatus::InProgress->label(),
                        ReservationStatus::Completed->value => ReservationStatus::Completed->label(),
                        ReservationStatus::Cancelled->value => ReservationStatus::Cancelled->label(),
                    ])
                    ->native(false)
                    ->disabled(fn() => in_array($this->reservation->status, [
                        ReservationStatus::Completed,
                        ReservationStatus::Cancelled,
                    ]))
                    ->live()
                    ->afterStateUpdated(function (?string $state) {
                        $this->updateStatus($state);
                    }),
            ]);
    }

    public function updateStatus(?string $newStatus): void
    {
        if (!$newStatus || $newStatus === $this->reservation->status->value) {
            return;
        }

        $updateData = ['status' => $newStatus];

        if ($newStatus === ReservationStatus::Cancelled->value) {
            $updateData['cancelled_at'] = now();
        }

        $this->reservation->update($updateData);
        $this->reservation->refresh();

        Notification::make()
            ->success()
            ->title('Status Updated')
            ->body("Reservation status changed to {$this->reservation->status->label()}")
            ->send();
    }

    public function render(): View
    {
        return view('livewire.admin.reservations.show-reservation');
    }
}
