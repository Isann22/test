<?php

namespace App\Livewire\Admin\Reservations;

use App\Models\Reservation;
use App\Enums\ReservationStatus;
use App\Enums\PaymentStatus;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;

#[Layout('components.layouts.dashboard')]
class ListReservations extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Reservation::query()->with(['user', 'detail.city', 'detail.moment', 'detail.package', 'payment']))
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('reservation_code')
                    ->label('Reservation Code')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->copyMessage('Reservation code copied'),
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('detail.city.name')
                    ->label('City')
                    ->searchable(),
                TextColumn::make('detail.moment.name')
                    ->label('Moment')
                    ->searchable(),
                TextColumn::make('detail.photoshoot_date')
                    ->label('Date')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(ReservationStatus $state): string => match ($state) {
                        ReservationStatus::Pending => 'warning',
                        ReservationStatus::Confirmed => 'info',
                        ReservationStatus::InProgress => 'primary',
                        ReservationStatus::Completed => 'success',
                        ReservationStatus::Cancelled => 'danger',
                    })
                    ->formatStateUsing(fn(ReservationStatus $state): string => $state->label()),
                TextColumn::make('payment.payment_status')
                    ->label('Payment')
                    ->badge()
                    ->color(fn(?PaymentStatus $state): string => match ($state) {
                        PaymentStatus::Settlement => 'success',
                        PaymentStatus::Pending => 'warning',
                        PaymentStatus::Failure, PaymentStatus::Expired => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(?PaymentStatus $state): string => $state?->label() ?? '-'),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->recordActions([
                Action::make('view')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Reservation $record): string => route('admin.reservations.show', $record)),
            ]);
    }

    public function render(): View
    {
        return view('livewire.admin.reservations.list-reservations');
    }
}
