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
class CreatePackage extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
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

    public function create(): void
    {
        $data = $this->form->getState();

        Package::create($data);

        Notification::make()
            ->title('Package created successfully!')
            ->success()
            ->send();

        $this->redirect(route('admin.packages.index'));
    }

    public function render(): View
    {
        return view('livewire.admin.packages.create-package');
    }
}
