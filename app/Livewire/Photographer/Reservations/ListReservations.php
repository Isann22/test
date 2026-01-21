<?php

namespace App\Livewire\Photographer\Reservations;

use App\Models\ReservationDetail;
use App\Enums\ReservationStatus;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.dashboard')]
class ListReservations extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => ReservationDetail::query()
                ->where('photographer_id', Auth::id())
                ->with(['reservation.user', 'city', 'moment', 'package']))
            ->columns([
                TextColumn::make('reservation.reservation_code')
                    ->label('Reservation Code')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Reservation code copied'),
                TextColumn::make('reservation.user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('city.name')
                    ->label('City')
                    ->searchable(),
                TextColumn::make('moment.name')
                    ->label('Moment')
                    ->searchable(),
                TextColumn::make('photoshoot_date')
                    ->label('Date')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('photoshoot_time')
                    ->label('Time')
                    ->sortable(),
                TextColumn::make('reservation.status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(ReservationStatus $state): string => match ($state) {
                        ReservationStatus::Pending => 'warning',
                        ReservationStatus::Confirmed => 'info',
                        ReservationStatus::InProgress => 'primary',
                        ReservationStatus::Completed => 'success',
                        ReservationStatus::Cancelled => 'danger',
                    })
                    ->formatStateUsing(fn(ReservationStatus $state): string => $state->label()),
                TextColumn::make('drive_link')
                    ->label('Drive Link')
                    ->badge()
                    ->color(fn(?string $state): string => $state ? 'success' : 'warning')
                    ->formatStateUsing(fn(?string $state): string => $state ? 'Uploaded' : 'Pending')
                    ->toggleable(),
            ])
            ->defaultSort('photoshoot_date', 'asc')
            ->filters([
                SelectFilter::make('reservation.status')
                    ->label('Status')
                    ->options([
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn(Builder $query, $value): Builder => $query->whereHas(
                                'reservation',
                                fn(Builder $q) => $q->where('status', $value)
                            )
                        );
                    }),
            ])
            ->recordActions([
                Action::make('view')
                    ->icon('heroicon-o-eye')
                    ->url(fn(ReservationDetail $record): string => route('reservations.show', $record)),
            ]);
    }

    public function render(): View
    {
        return view('livewire.photographer.reservations.list-reservations');
    }
}
