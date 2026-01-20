<?php

namespace App\Livewire\Admin\Cities;

use App\Models\City;
use App\Models\Package;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;

#[Layout('components.layouts.dashboard')]
class CreateCity extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

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
                Section::make('City Information')
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
                    ]),

                Section::make('Albums')
                    ->schema([
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

        // Sync packages with pivot data
        $packagesSync = [];
        foreach ($data['packages'] ?? [] as $package) {
            $packagesSync[$package['package_id']] = ['price' => $package['price']];
        }
        $this->city->packages()->sync($packagesSync);

        // Save media via form
        $this->form->saveRelationships();

        Notification::make()
            ->title('City created successfully!')
            ->success()
            ->send();

        $this->redirect(route('cities.list'));
    }

    public function render(): View
    {
        return view('livewire.admin.cities.create-city');
    }
}
