<?php

namespace App\Livewire\Admin\moments;

use App\Models\Moment;
use Livewire\Component;
use Filament\Schemas\Schema;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Notifications\Notification;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

#[Layout('components.layouts.dashboard')]
class EditMoment extends Component implements HasForms
{
    use InteractsWithForms;

    public Moment $record;
    public ?array $data = [];

    public function mount(Moment $moment): void
    {
        $this->record = $moment;

        $this->form->fill([
            'name' => $moment->name,
            'details' => $moment->details,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Moment Name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('details')
                    ->label('Details')
                    ->rows(4),
                SpatieMediaLibraryFileUpload::make('albums')
                    ->label('Images')
                    ->collection('albums')
                    ->multiple()
                    ->reorderable()
                    ->image()
                    ->imageEditor()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(5120),
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->record->update([
            'name' => $data['name'],
            'details' => $data['details'],
        ]);

        $this->form->saveRelationships();

        Notification::make()
            ->title('Moment updated successfully!')
            ->success()
            ->send();

        $this->redirect(route('moments.list'));
    }

    public function render(): View
    {
        return view('livewire.admin.moments.edit-moment');
    }
}
