<?php

namespace App\Livewire\Admin\moments;

use App\Models\Moment;
use Livewire\Component;
use Filament\Schemas\Schema;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

#[Layout('components.layouts.dashboard')]
class CreateMoment extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ?array $data = [];
    public ?Moment $moment = null;


    public function mount(): void
    {
        $this->moment = new Moment();
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                Textarea::make('details')
                    ->columnSpanFull(),

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
            ->model(Moment::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $this->moment->fill([
            'name' => $data['name'],
            'details' => $data['details'] ?? null,
        ]);

        $this->moment->save();

        $this->form->saveRelationships();

        Notification::make()
            ->title('Moment created successfully!')
            ->success()
            ->send();

        $this->redirect(route('moments.list'));
    }

    public function render(): View
    {
        return view('livewire.admin.moments.create-moment');
    }
}
