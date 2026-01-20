<?php

namespace App\Livewire\Admin\PhotographerApplicants;

use App\Enums\ApplicantStatus;
use Livewire\Component;
use Filament\Schemas\Schema;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use App\Models\PhotographerApplicant;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;

#[Layout('components.layouts.dashboard')]
class ShowPhotographerApplicant extends Component implements HasForms
{
    use InteractsWithForms;

    public PhotographerApplicant $record;
    public ?string $status = null;

    public function mount(PhotographerApplicant $photographer): void
    {
        $this->record = $photographer;
        $this->status = $this->record->status?->value;
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Select::make('status')
                    ->label('Update Status')
                    ->options([
                        ApplicantStatus::Review->value => ApplicantStatus::Review->label(),
                        ApplicantStatus::Hired->value => ApplicantStatus::Hired->label(),
                        ApplicantStatus::Rejected->value => ApplicantStatus::Rejected->label(),
                    ])
                    ->native(false)
                    ->disabled(fn() => in_array($this->record->status, [
                        ApplicantStatus::Hired,
                        ApplicantStatus::Rejected,
                    ]))
                    ->live()
                    ->afterStateUpdated(function (?string $state) {
                        $this->updateStatus($state);
                    }),
            ]);
    }

    public function updateStatus(?string $newStatus): void
    {
        if (!$newStatus || $newStatus === $this->record->status?->value) {
            return;
        }

        $this->record->update(['status' => $newStatus]);
        $this->record->refresh();

        Notification::make()
            ->success()
            ->title('Status Updated')
            ->body("Applicant status changed to {$this->record->status->label()}")
            ->send();
    }

    public function render(): View
    {
        return view('livewire.admin.photographer-applicants.show-photographer-applicant');
    }
}
