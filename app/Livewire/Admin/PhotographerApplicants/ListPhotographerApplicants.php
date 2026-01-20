<?php

namespace App\Livewire\Admin\PhotographerApplicants;

use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Livewire\Attributes\Layout;
use App\Models\PhotographerApplicant;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Infolists\Concerns\InteractsWithInfolists;




#[Layout('components.layouts.dashboard')]
class ListPhotographerApplicants extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(PhotographerApplicant::query())
            ->columns([
                TextColumn::make('fullname')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Action::make('view')
                    ->icon('heroicon-s-eye')
                    ->url(fn (PhotographerApplicant $record) => route('photographers-applicant-view', $record)),
            ]);
    }

    public function render()
    {
        return view('livewire.admin.photographer-applicants.list-photographer-applicants');
    }
}
