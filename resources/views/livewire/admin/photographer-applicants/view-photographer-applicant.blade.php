<div class="p-8 mx-auto max-w-7xl">
    <x-mary-header title="Detail Fotografer" subtitle="Manajemen Data Fotografer" separator>
        <x-slot:actions>
            <x-mary-button label="Edit" icon="o-pencil" link="/admin/photographers/{{ $record->id }}/edit"
                class="btn-primary" />
            <x-mary-button label="Kembali" icon="o-arrow-left" link="{{ route('photographer-applicants-list') }}" />
        </x-slot:actions>
    </x-mary-header>

    <div class="mt-6">
        {{-- Panggil sesuai nama method di class --}}
        {{ $this->photographerSchema }}
    </div>
</div>
