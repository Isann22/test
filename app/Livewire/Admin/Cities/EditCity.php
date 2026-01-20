<?php

namespace App\Livewire\Admin\cities;

use App\Models\City;
use Livewire\Component;
use Filament\Schemas\Schema;
use Livewire\Attributes\Layout;
use Filament\Actions\EditAction;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;


#[Layout('components.layouts.dashboard')]
class EditCity extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public City $record;

    public ?array $data = [];

    public function mount(City $city): void
    {
        $this->record = $city;

        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('details')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                EditAction::make()
                    ->successRedirectUrl(route('cities.list'))
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('City updated')
                            ->body("City {$this->record->name} has been updated successfully!"),
                    )
                    ->using(function (City $record, array $data): City {
                        $data = $this->form->getState();
                        $record->update($data);
                        return $record;
                    })
            ])
            ->statePath('data')
            ->model($this->record);
    }


    public function render(): View
    {
        return view('livewire.admin.cities.edit-city');
    }
}
