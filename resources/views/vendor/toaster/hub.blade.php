<div role="status" id="toaster" x-data="toasterHub(@js($toasts), @js($config))" @class([
    'fixed z-50 p-4 w-full flex flex-col pointer-events-none sm:p-6',
    'bottom-0' => $alignment->is('bottom'),
    'top-1/2 -translate-y-1/2' => $alignment->is('middle'),
    'top-0' => $alignment->is('top'),
    'items-start rtl:items-end' => $position->is('left'),
    'items-center' => $position->is('center'),
    'items-end rtl:items-start' => $position->is('right'),
])>
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.isVisible" x-init="$nextTick(() => toast.show($el))" @if ($alignment->is('bottom'))
            x-transition:enter-start="translate-y-12 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
        @elseif($alignment->is('top'))
            x-transition:enter-start="-translate-y-12 opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
        @else
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            @endif
            x-transition:leave-end="opacity-0 scale-90"
            @class([
                'relative duration-300 transform transition text-gray-200 ease-in-out max-w-xs w-full pointer-events-auto',
                'text-center' => $position->is('center'),
            ])
            >
            <div class="inline-flex items-center gap-3 group select-none backdrop-blur-md pl-4 pr-8 py-4 rounded-xl shadow-2xl text-sm font-medium w-full ring-1 ring-inset {{ $alignment->is('bottom') ? 'mt-3' : 'mb-3' }}"
                :class="toast.select({
                    error: 'bg-red-50 text-red-800 ring-red-200',
                    info: 'bg-blue-50 text-blue-800 ring-blue-200',
                    success: 'bg-emerald-50 text-emerald-800 ring-emerald-200',
                    warning: 'bg-amber-50 text-amber-800 ring-amber-200'
                })">
                {{-- Success Icon --}}
                <div x-show="toast.type === 'success'" class="flex-shrink-0 p-1.5 bg-emerald-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" class="text-emerald-600">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <path d="m9 11 3 3L22 4"></path>
                    </svg>
                </div>
                {{-- Info Icon --}}
                <div x-show="toast.type === 'info'" class="flex-shrink-0 p-1.5 bg-blue-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" class="text-blue-600">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 16v-4"></path>
                        <path d="M12 8h.01"></path>
                    </svg>
                </div>
                {{-- Warning Icon --}}
                <div x-show="toast.type==='warning'" class="flex-shrink-0 p-1.5 bg-amber-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" class="text-amber-600">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path>
                        <path d="M12 9v4"></path>
                        <path d="M12 17h.01"></path>
                    </svg>
                </div>
                {{-- Error Icon --}}
                <div x-show="toast.type === 'error'" class="flex-shrink-0 p-1.5 bg-red-100 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round" class="text-red-600">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="m15 9-6 6"></path>
                        <path d="m9 9 6 6"></path>
                    </svg>
                </div>
                <span class="font-semibold" x-text="toast.message"></span>
                @if ($closeable)
                    <button x-on:click="toast.dispose()" aria-label="@lang('close')"
                        class="absolute hidden group-hover:block text-gray-400 cursor-pointer opacity-80 hover:opacity-100 right-0 p-2 focus:outline-none focus:outline-hidden rtl:right-auto rtl:left-0 {{ $alignment->is('bottom') ? 'top-3' : 'top-0' }}">
                        <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    </template>
</div>
