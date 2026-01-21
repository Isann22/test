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
use Zap\Enums\ScheduleTypes;

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
                    ->options(fn() => $this->getAvailablePhotographers())
                    ->searchable()
                    ->placeholder('Select a photographer')
                    ->native(false)
                    ->helperText('Only photographers available on the booking date/time are shown')
                    ->live()
                    ->afterStateUpdated(function (?string $state) {
                        $this->assignPhotographer($state);
                    }),
            ]);
    }

    /**
     * Get photographers available for this reservation's date/time.
     */
    protected function getAvailablePhotographers(): array
    {
        $detail = $this->reservation->detail;
        $date = $detail->photoshoot_date->format('Y-m-d');
        $startTime = $detail->photoshoot_time;
        $endTime = $detail->end_time;
        $cityName = $detail->city->name;
        $momentName = $detail->moment->name;

        // Get all active photographers that cover this city and moment
        $photographers = User::query()
            ->whereHas('photographerProfile', function ($q) use ($cityName, $momentName) {
                $q->where('is_active', true)
                 ;
            })
            ->with('photographerProfile')
            ->get();

        $available = [];
        

        foreach ($photographers as $photographer) {
            // Check if photographer has any blocking schedule at this time
            $hasConflict = $photographer->schedules()
                ->active()
                ->forDate($date)
                ->whereIn('schedule_type', [
                    ScheduleTypes::APPOINTMENT->value,
                    ScheduleTypes::BLOCKED->value,
                ])
                ->whereHas('periods', function ($query) use ($startTime, $endTime) {
                    $query->where(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<', $endTime)
                          ->where('end_time', '>', $startTime);
                    });
                })
                ->exists();

            if (!$hasConflict) {
                $available[$photographer->id] = $photographer->name;
            }
        }

        return $available;
    }

    public function assignPhotographer(?string $photographerId): void
    {
        if (!$photographerId) {
            return;
        }

        $photographer = User::findOrFail($photographerId);
        $detail = $this->reservation->detail;

      
        $startTime = \Carbon\Carbon::parse($detail->photoshoot_time)->format('H:i');
        $endTime = \Carbon\Carbon::parse($detail->end_time)->format('H:i');
        
        $photographer->createSchedule()
            ->appointment()
            ->from($detail->photoshoot_date)
            ->named("Booking: {$this->reservation->reservation_code}")
            ->description("Photoshoot for {$this->reservation->user->name}")
            ->addPeriod($startTime, $endTime)
            ->save();

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
