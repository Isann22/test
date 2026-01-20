<?php

namespace App\Livewire\Admin\Cities;

use App\Models\City;
use App\Models\Package;
use Livewire\Component;
use Filament\Schemas\Schema;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Notifications\Notification;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

#[Layout('components.layouts.dashboard')]
class EditCity extends Component implements HasForms
{
    use InteractsWithForms;

    public City $record;
    public ?array $data = [];

    public function mount(City $city): void
    {
        $this->record = $city;

        // Prepare packages data for repeater
        $packages = $city->packages->map(function ($package) {
            return [
                'package_id' => $package->id,
                'price' => $package->pivot->price,
            ];
        })->toArray();

        $this->form->fill([
            'name' => $city->name,
            'details' => $city->details,
            'price' => $city->price,
            'packages' => $packages,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('City Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('City Name')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('details')
                            ->label('Details')
                            ->rows(4),
                        TextInput::make('price')
                            ->label('Base Price')
                            ->required()
                            ->numeric()
                            ->prefix('IDR'),
                    ]),

                Section::make('Albums')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('albums')
                            ->collection('albums')
                            ->multiple()
                            ->reorderable()
                            ->image()
                            ->imageEditor()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120),
                    ]),

                Section::make('Packages')
                    ->description('Assign packages to this city with specific prices')
                    ->schema([
                        Repeater::make('packages')
                            ->schema([
                                Select::make('package_id')
                                    ->label('Package')
                                    ->options(Package::pluck('name', 'id'))
                                    ->required()
                                    ->distinct()
                                    ->searchable(),
                                TextInput::make('price')
                                    ->label('Price for this City')
                                    ->required()
                                    ->numeric()
                                    ->prefix('IDR'),
                            ])
                            ->columns(2)
                            ->addActionLabel('Add Package')
                            ->reorderable(false)
                            ->defaultItems(0),
                    ]),
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Update city basic info
        $this->record->update([
            'name' => $data['name'],
            'details' => $data['details'],
            'price' => $data['price'],
        ]);

        // Sync packages with pivot data
        $packagesSync = [];
        foreach ($data['packages'] ?? [] as $package) {
            $packagesSync[$package['package_id']] = ['price' => $package['price']];
        }
        $this->record->packages()->sync($packagesSync);

        // Save media
        $this->form->saveRelationships();

        Notification::make()
            ->title('City updated successfully!')
            ->success()
            ->send();

        $this->redirect(route('cities.list'));
    }

    public function render(): View
    {
        return view('livewire.admin.cities.edit-city');
    }
}
