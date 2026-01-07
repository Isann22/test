<div class="container mx-auto px-4 py-12">

    {{-- Header Skeleton --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
        <div>
            {{-- Judul Skeleton --}}
            <div class="skeleton h-10 w-64 mb-2"></div>
            <div class="skeleton h-4 w-48"></div>
        </div>

        {{-- Search Input Skeleton --}}
        <div class="w-full md:w-1/3">
            <div class="skeleton h-12 w-full rounded-full"></div>
        </div>
    </div>

    {{-- Grid Skeleton --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 place-items-center">

        {{-- Loop 6 kali biar terlihat penuh --}}
        @foreach (range(1, 6) as $i)
            <div class="w-full max-w-sm rounded shadow-md bg-white overflow-hidden">
                {{-- Skeleton Gambar --}}
                <div class="skeleton w-full h-64 rounded-none"></div>

                {{-- Skeleton Caption --}}
                <div class="p-6 space-y-3 relative">
                    {{-- Gradient overlay simulation --}}
                    <div class="skeleton h-6 w-3/4"></div>
                    <div class="skeleton h-4 w-1/2"></div>
                </div>
            </div>
        @endforeach

    </div>
</div>
