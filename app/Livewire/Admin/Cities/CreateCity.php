<?php

namespace App\Livewire\Admin\Cities;

use App\Models\City;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;

#[Layout('components.layouts.dashboard')]
class CreateCity extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public ?City $city = null;

    public function mount(): void
    {
        $this->city = new City();
        $this->form->fill();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('City Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter city name'),

                Textarea::make('details')
                    ->label('Details')
                    ->rows(4)
                    ->placeholder('Enter city details/description'),

                TextInput::make('price')
                    ->label('Base Price')
                    ->required()
                    ->numeric()
                    ->prefix('IDR')
                    ->placeholder('0'),

                SpatieMediaLibraryFileUpload::make('albums')
                    ->label('Album Images')
                    ->collection('albums')
                    ->multiple()
                    ->reorderable()
                    ->image()
                    ->imageEditor()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(5120)
                    ->helperText('Upload album images (max 5MB each)'),
            ])
            ->statePath('data')
            ->model($this->city);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $this->city->fill([
            'name' => $data['name'],
            'details' => $data['details'] ?? null,
            'price' => $data['price'],
        ]);

        $this->city->save();

        // Save media via form
        $this->form->saveRelationships();

        Notification::make()
            ->title('City created successfully!')
            ->success()
            ->send();

        $this->redirect('/admin/cities');
    }

    public function render(): View
    {
        return view('livewire.admin.cities.create-city');
    }
}
