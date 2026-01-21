<?php

namespace App\Livewire\Admin\Photographers;

use App\Models\User;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Livewire\Attributes\Layout;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;

#[Layout('components.layouts.dashboard')]
class ListPhotographers extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->whereHas('photographerProfile')
                    ->with('photographerProfile')
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone_number')
                    ->label('Phone'),
                TextColumn::make('photographerProfile.cities')
                    ->label('Cities')
                    ->badge()
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state),
                ToggleColumn::make('photographerProfile.is_active')
                    ->label('Active')
                    ->onColor('success')
                    ->offColor('danger')
                    ->afterStateUpdated(function (User $record, $state) {
                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('Status Updated')
                            ->body("{$record->name} has been " . ($state ? 'activated' : 'deactivated'))
                            ->send();
                    }),
                TextColumn::make('photographerProfile.rating')
                    ->label('Rating')
                    ->suffix(' ⭐'),
                TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Action::make('view')
                    ->icon('heroicon-s-eye')
                    ->url(fn (User $record) => route('admin.photographers.show', $record)),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive')
                    ->queries(
                        true: fn ($query) => $query->whereHas('photographerProfile', fn ($q) => $q->where('is_active', true)),
                        false: fn ($query) => $query->whereHas('photographerProfile', fn ($q) => $q->where('is_active', false)),
                    ),
            ]);
    }

    public function render()
    {
        return view('livewire.admin.photographers.list-photographers');
    }
}
