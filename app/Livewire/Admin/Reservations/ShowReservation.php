<?php

namespace App\Livewire\Admin\Reservations;

use App\Models\Reservation;
use App\Models\User;
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
    public ?string $photographer_id = null;

    public function mount(Reservation $reservation): void
    {
        $this->reservation = $reservation->load([
            'user',
            'detail.city',
            'detail.moment',
            'detail.package',
            'detail.photographer',
            'payment'
        ]);
        
        $this->status = $this->reservation->status->value;
        $this->photographer_id = $this->reservation->detail?->photographer_id;
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

    public function photographerForm(Schema $form): Schema
    {
        return $form
            ->schema([
                Select::make('photographer_id')
                    ->label('Assign Photographer')
                    ->options(
                        User::query()
                            ->whereHas('photographerProfile', fn($q) => $q->where('is_active', true))
                            ->pluck('name', 'id')
                    )
                    ->searchable()
                    ->placeholder('Select a photographer')
                    ->native(false)
                    ->live()
                    ->afterStateUpdated(function (?string $state) {
                        $this->assignPhotographer($state);
                    }),
            ]);
    }

    public function assignPhotographer(?string $photographerId): void
    {
        if (!$photographerId) {
            return;
        }

        // Update photographer in reservation detail
        $this->reservation->detail->update([
            'photographer_id' => $photographerId
        ]);

        // Auto update status to in_progress
        $this->reservation->update([
            'status' => ReservationStatus::InProgress->value
        ]);

        $this->reservation->refresh();
        $this->reservation->load(['detail.photographer']);
        $this->status = $this->reservation->status->value;

        $photographer = User::findOrFail($photographerId);

        Notification::make()
            ->success()
            ->title('Photographer Assigned')
            ->body("{$photographer->name} has been assigned. Status updated to In Progress.")
            ->send();
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

    protected function getForms(): array
    {
        return [
            'form',
            'photographerForm',
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.reservations.show-reservation');
    }
}
