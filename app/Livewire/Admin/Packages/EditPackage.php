<?php

namespace App\Livewire\Admin\Packages;

use App\Models\Package;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;

#[Layout('components.layouts.dashboard')]
class EditPackage extends Component implements HasForms
{
    use InteractsWithForms;

    public Package $package;
    public ?array $data = [];

    public function mount(Package $package): void
    {
        $this->package = $package;
        $this->form->fill([
            'name' => $package->name,
            'hour_duration' => $package->hour_duration,
            'edited_photos' => $package->edited_photos,
            'downloadable_photos' => $package->downloadable_photos,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Package Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Basic, Standard, Premium'),

                TextInput::make('hour_duration')
                    ->label('Duration (Hours)')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->placeholder('e.g. 2'),

                TextInput::make('edited_photos')
                    ->label('Edited Photos')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->placeholder('e.g. 30'),

                TextInput::make('downloadable_photos')
                    ->label('Downloadable Photos')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->placeholder('e.g. 100'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->package->update($data);

        Notification::make()
            ->title('Package updated successfully!')
            ->success()
            ->send();

        $this->redirect(route('admin.packages.index'));
    }

    public function render(): View
    {
        return view('livewire.admin.packages.edit-package');
    }
}
