<?php

namespace App\Livewire\Admin\PhotographerApplicants;

use Livewire\Component;
use Filament\Schemas\Schema;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use App\Models\PhotographerApplicant;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Concerns\InteractsWithSchemas;

#[Layout('components.layouts.dashboard')]
class ViewPhotographerApplicant extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public PhotographerApplicant $record;

    public function mount(PhotographerApplicant $photographer): void
    {
        $this->record = $photographer;
    }

    public function photographerSchema(Schema $schema): Schema
    {
        return $schema
            ->record($this->record)
            ->components([
                Section::make('Profil Fotografer')
                    ->description('Informasi detail akun dan keahlian.')
                    ->schema([
                        Grid::make(3)
                            ->schema([

                                // Data Utama
                                Group::make([
                                    TextEntry::make('fullname')
                                        ->label('Nama Lengkap')
                                        ->weight('bold')
                                        ->size('lg'),
                                    TextEntry::make('email')
                                        ->copyable()
                                        ->color('gray'),
                                    TextEntry::make('phonenumber')
                                        ->label('WhatsApp/Telp')
                                        ->icon('heroicon-m-phone'),
                                ])->columnSpan(2),
                            ]),
                    ]),

                Grid::make(2)
                    ->schema([
                        Section::make('Keahlian & Jangkauan')
                            ->schema([
                                TextEntry::make('cameras')
                                    ->label('Kamera & Gear')
                                    ->badge()
                                    ->color('warning'),
                                TextEntry::make('cities')
                                    ->label('Kota')
                                    ->badge()
                                    ->color('success'),
                                TextEntry::make('moments')
                                    ->label('Spesialisasi')
                                    ->badge()
                                    ->color('info'),
                            ])->columnSpan(1),

                        Section::make('Tautan Sosial')
                            ->schema([
                                TextEntry::make('instagram_link')
                                    ->label('Instagram')
                                    ->url(fn($record) => $record->instagram_link, true)
                                    ->color('primary')
                                    ->icon('heroicon-m-link'),
                                TextEntry::make('portofolio_link')
                                    ->label('Portofolio')
                                    ->url(fn($record) => $record->portofolio_link, true)
                                    ->color('primary')
                                    ->icon('heroicon-m-globe-alt'),
                            ])->columnSpan(1),
                    ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.admin.photographer-applicants.view-photographer-applicant');
    }
}
