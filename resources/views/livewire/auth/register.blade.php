<div class="p-6 xl:p-10 rounded-lg flex-1">

    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-600">Welcome! Let's make life
            memorable.</h2>
    </div>


    <form wire:submit="register" x-data="{
        step: 1,
        loading: false,
        async nextStep() {
            this.loading = true;
            let isValid = await $wire.validateEmail();
    
            this.loading = false;
            if (isValid) {
                this.step = 2;
            }
        },
        initTelInput() {
            const input = this.$refs.phoneInput;
            if (!input) return;
            window.intlTelInput(input, {
                initialCountry: 'id',
                separateDialCode: true,
                autoPlaceholder: 'off',
                formatOnDisplay: true,
                utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js',
            });
        }
    }" x-init="initTelInput()"
        class="mt-7 w-11/12 xl:w-3/4 2xl:w-2/3 mx-auto space-y-4">

        <div x-show="step === 1" class="flex flex-col gap-4">
            <x-form.input-text label="Email Address" name="email" wire:model="email" placeholder="hello@example.com"
                required />

            <button type="button" @click="nextStep()" :disabled="loading"
                class="btn-primary px-4 py-2 w-full mt-4 flex items-center justify-center">
                <span x-show="!loading">Next</span>
                <span x-show="loading" class="flex items-center">
                    <x-spinner class="ml-2 size-4" />
                </span>
            </button>
        </div>

        <div x-show="step === 2" x-cloak class="flex flex-col gap-4">
            <x-form.input-text label="Full Name" name="name" wire:model="name" placeholder="John" required />
            <x-form.input-text label="Password" type="password" name="password" wire:model="password"
                placeholder="********" required />
            <x-form.input-text label="Confirm Password" type="password" name="password_confirmation"
                wire:model="password_confirmation" required placeholder="********" />

            <div wire:ignore>
                <x-form.input-text x-ref="phoneInput" id="phone" label="Phone Number" type="tel" name="phone"
                    wire:model="phone" required />
            </div>

            <div class="flex gap-2 mt-4">
                <button type="button" @click="step = 1" class="bg-gray-200 text-gray-700 px-4 py-2 rounded">
                    Back
                </button>

                <button type="submit" class="btn-primary px-4 py-2 flex-1">
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

    <div class="flex gap-4">
        <button
            class="flex items-center justify-center gap-3 w-full py-2.5 border border-gray-300 rounded bg-white text-gray-700 hover:bg-gray-50 transition">
            <img src="https://www.gstatic.com/images/branding/product/1x/gsa_64dp.png" alt="Google" class="w-7 h-7">
            <span class="font-medium">Google</span>
        </button>

        <button
            class="flex items-center justify-center gap-3 w-full py-2.5 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg" alt="Facebook"
                class="w-7 h-7 invert">
            <span class="font-medium">Facebook</span>
        </button>
    </div>



</div>



@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    @script
        <script>
            const input = document.querySelector("#phone");
            const iti = window.intlTelInput(input, {
                initialCountry: "id",
                separateDialCode: true,
                autoPlaceholder: "off",
                formatOnDisplay: true,
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
            });


            $js('phone', () => {

                if (iti.isValidNumber()) {
                    const fullNumber = iti.getNumber()
                    $wire.phone = fullNumber

                    $wire.register()
                } else {
                    Toaster.error('Invalid Number')
                }

            })
        </script>
    @endscript
@endpush
