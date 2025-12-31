<div class=" p-6 xl:p-10 rounded-xl border border-zinc-200 flex-1">

    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-600">Welcome! Let's make life
            memorable.</h2>
    </div>

    <form x-data="{
        step: 1,
        loading: false,
        init() {
            const input = this.$refs.phoneInput;
            if (input) {
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
        async nextStep() {
            this.loading = true;
    
            let isValid = await $wire.validateEmail();
            this.loading = false;
            if (isValid) {
                this.step++;
            }
        },
        async submitRegistration() {
            if (!this.iti) return;
            const fullNumber = this.iti.getNumber();
            $wire.set('phone', fullNumber);
            await $wire.register();
        }
    
    }" class="mt-7 w-11/12 xl:w-3/4 2xl:w-2/3 mx-auto space-y-4">

        <div x-show="step === 1" class="flex flex-col gap-4">
            <x-form.input-text label="Email Address" name="email" wire:model="email" placeholder="Email" required />

            <button type="button" @click="nextStep()"
                class="btn btn-neutral text-base-100 px-4 py-2 w-full mt-4
                flex items-center justify-center">
                <span x-show="!loading">Next</span>
                <span x-show="loading" class="flex items-center">
                    <x-spinner class="size-6" />
                </span>
            </button>
        </div>

        <div x-show="step === 2" x-cloak class="flex flex-col gap-4">
            <x-form.input-text label="Full Name" name="full_name" wire:model="full_name" placeholder="Full Name"
                required />
            <div>

            </div>
            <x-form.input-text label="Password" type="password" name="password" wire:model="password"
                placeholder="Password" required />

            <x-form.input-text label="Confirm Password" type="password" name="password_confirmation"
                wire:model="password_confirmation" required placeholder="Confirm Password" />


            <div wire:ignore>
                <x-form.input-text class="w-full" x-ref="phoneInput" label="Phone Number" type="tel" name="phone"
                    wire:model="phone" required />

            </div>
            @error('phone')
                <p class="label text-sm text-red-500">{{ $message }}</p>
            @enderror

            <div class="flex gap-2 mt-4">
                <button type="button" @click="step = 1" class="btn px-4 py-2 rounded">
                    Back
                </button>

                <button @click.prevent="submitRegistration()" class="btn-neutral text-base-100 px-4 py-2 flex-1">
                    <span wire:loading.remove wire:target="register">Sign Up</span>
                    <x-spinner class="size-6" wire:loading wire:target="register" />
                </button>
            </div>
        </div>
    </form>


    <div class="flex items-center justify-center gap-5 mt-4">
        <p class="text-xs text-gray-400 flex items-center gap-1">
            Already have an account? <a wire:navigate.hover href="{{ route('login') }}"
                class="text-blue-500 hover:text-blue-400 font-semibold">Login</a>
        </p>
    </div>

    <div class="relative flex items-center mb-8">
        <div class="flex-grow border-t border-gray-200"></div>
        <span class="flex-shrink mx-4 text-gray-400 text-sm font-light">Or register with</span>
        <div class="flex-grow border-t border-gray-200"></div>
    </div>

    <x-social-login />

</div>



@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@20.3.0/build/js/intlTelInput.min.js"></script>
@endpush
