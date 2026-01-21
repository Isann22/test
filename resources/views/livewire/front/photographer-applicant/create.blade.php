<div class="min-h-screen py-12 bg-base-200/30" x-data="{
    iti: null,
    initPhoneInput() {
        const input = this.$refs.phoneInput;
        if (input && !this.iti) {
            this.iti = window.intlTelInput(input, {
                initialCountry: 'id',
                showFlags: false,
                autoPlaceholder: 'off',
                nationalMode: true,
                formatOnDisplay: true,
                containerClass: 'w-full',
                showSelectedDialCode: true,
                utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@20.3.0/build/js/utils.js'
            });
        }
    },
    init() {
        const tryInit = () => {
            if (typeof window.intlTelInput === 'function') {
                this.initPhoneInput();
            } else {
                setTimeout(tryInit, 100);
            }
        };
        tryInit();
    },
    async submitForm() {
        if (this.iti) {
            const fullNumber = this.iti.getNumber();
            $wire.set('form.phonenumber', fullNumber);
        }
        await $wire.submit();
    }
}">
    <div class="container mx-auto px-4 max-w-3xl">

        <div class="text-center mb-10">
            <h1 class="text-4xl md:text-5xl font-bold text-base-content mb-4">Join as a Photographer</h1>
            <p class="text-lg text-base-content/70">Become part of our professional photographer team</p>
        </div>

        <div class="card bg-base-100 shadow-2xl">
            <div class="card-body p-6 md:p-10">
                <form @submit.prevent="submitForm()" class="space-y-6">

                    {{-- Personal Information --}}
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-base-content border-b pb-2">Personal Information</h3>

                        <x-mary-input label="Full Name" wire:model="form.fullname" placeholder="Enter your full name"
                            icon="o-user" />

                        <x-mary-input label="Email" type="email" wire:model="form.email"
                            placeholder="example@email.com" icon="o-envelope" />

                        <div wire:ignore>
                            <label class="label">
                                <span class="label-text font-medium">Phone Number</span>
                            </label>
                            <input type="tel" x-ref="phoneInput" class="input input-bordered w-full"
                                placeholder="812 3456 7890" />
                        </div>
                        @error('form.phonenumber')
                            <p class="text-error text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Social & Portfolio Links --}}
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-base-content border-b pb-2">Social Media & Portfolio Links
                        </h3>

                        <x-mary-input label="Instagram Link" wire:model="form.instagram_link"
                            placeholder="https://instagram.com/username" icon="o-camera" />

                        <x-mary-input label="Portfolio Link" wire:model="form.portofolio_link"
                            placeholder="https://yourportfolio.com" icon="o-link" />
                    </div>

                    {{-- Cameras --}}
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-base-content border-b pb-2">Camera Equipment</h3>

                        <x-mary-input label="Cameras" wire:model="form.cameras"
                            placeholder="e.g. Canon EOS R5, Sony A7III, Fujifilm X-T5" icon="o-camera"
                            hint="Separate with commas if more than one" />
                    </div>

                    {{-- Moments Selection --}}
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-base-content border-b pb-2">Moments You Specialize In</h3>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach ($moments as $moment)
                                <label class="cursor-pointer">
                                    <input type="checkbox" wire:model="form.selectedMoments" value="{{ $moment->name }}"
                                        class="checkbox checkbox-primary hidden peer" />
                                    <div
                                        class="card bg-base-200 peer-checked:bg-primary peer-checked:text-primary-content transition-all duration-200 hover:shadow-md">
                                        <div class="card-body p-4 items-center text-center">
                                            <x-mary-icon name="o-camera" class="w-6 h-6" />
                                            <span class="font-medium text-sm">{{ $moment->name }}</span>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        @error('form.selectedMoments')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Cities Selection --}}
                    <div class="space-y-4">
                        <h3 class="text-xl font-bold text-base-content border-b pb-2">Available Cities</h3>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach ($cities as $city)
                                <label class="cursor-pointer">
                                    <input type="checkbox" wire:model="form.selectedCities" value="{{ $city->name }}"
                                        class="checkbox checkbox-primary hidden peer" />
                                    <div
                                        class="card bg-base-200 peer-checked:bg-primary peer-checked:text-primary-content transition-all duration-200 hover:shadow-md">
                                        <div class="card-body p-4 items-center text-center">
                                            <x-mary-icon name="o-map-pin" class="w-6 h-6" />
                                            <span class="font-medium text-sm">{{ $city->name }}</span>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        @error('form.selectedCities')
                            <p class="text-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-6">
                        <button type="submit" class="btn btn-primary btn-block btn-lg text-white shadow-lg">
                            <x-mary-icon name="o-paper-airplane" class="w-5 h-5" />
                            <span wire:loading.remove wire:target="submit">Submit Application</span>
                            <x-spinner class="size-6" wire:loading wire:target="submit" />

                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@20.3.0/build/js/intlTelInput.min.js"></script>
@endpush
