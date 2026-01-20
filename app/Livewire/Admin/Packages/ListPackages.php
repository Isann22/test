<?php

namespace App\Livewire\Admin\Packages;

use App\Models\Package;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Livewire\Attributes\Layout;
use Filament\Actions\DeleteAction;
use Illuminate\Contracts\View\View;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;

#[Layout('components.layouts.dashboard')]
class ListPackages extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Package::query()->withCount('cities'))
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')
                    ->label('Package Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('hour_duration')
                    ->label('Duration')
                    ->suffix(' hours')
                    ->sortable(),
                TextColumn::make('edited_photos')
                    ->label('Edited Photos')
                    ->sortable(),
                TextColumn::make('downloadable_photos')
                    ->label('Downloadable')
                    ->sortable(),
                TextColumn::make('cities_count')
                    ->label('Cities')
                    ->badge()
                    ->color('primary'),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name', 'asc')
            ->toolbarActions([
                Action::make('create')
                    ->label('Add Package')
                    ->url(route('admin.packages.create')),
            ])
            ->recordActions([
                Action::make('edit')
                    ->icon('heroicon-o-pencil')
                    ->url(fn(Package $record): string => route('admin.packages.edit', $record)),
                DeleteAction::make()
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Package deleted')
                            ->body('The package has been deleted successfully.'),
                    ),
            ]);
    }

    public function render(): View
    {
        return view('livewire.admin.packages.list-packages');
    }
}
