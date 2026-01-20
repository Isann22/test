<?php

namespace App\Livewire\Admin\moments;

use App\Models\Moment;
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
class EditMoment extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Moment $record;

    public ?array $data = [];

    public function mount(Moment $moment): void
    {
        $this->record = $moment;

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
                EditAction::make()
                    ->successRedirectUrl(route('moments.list'))
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Moment updated')
                            ->body("Moment {$this->record->name} has been updated successfully!"),
                    )
                    ->using(function (Moment $record, array $data): Moment {
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
        return view('livewire.admin.moments.edit-moment');
    }
}
