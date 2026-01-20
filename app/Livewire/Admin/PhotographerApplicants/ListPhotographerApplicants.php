<?php

namespace App\Livewire\Admin\PhotographerApplicants;

use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Layout;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use App\Models\PhotographerApplicant;
use Filament\Actions\Contracts\HasActions;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;




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

            ]);
    }

    public function render()
    {
        return view('livewire.admin.photographer-applicants.list-photographer-applicants');
    }
}
