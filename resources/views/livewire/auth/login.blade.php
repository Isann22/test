<div class="p-6 xl:p-10 rounded-lg flex-1">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-600">Sign in to your account</h2>
    </div>
    <form wire:submit="authenticate" class="mt-7 w-11/12 xl:w-3/4 2xl:w-2/3 mx-auto space-y-4">
        <x-form.input-text label="Email Address" name="email" placeholder="Email" required />
        <x-form.input-text label="Password" type="password" name="password" placeholder="Password" required />
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <input type="checkbox" id="remember" class="w-4 h-4 rounded-sm bg-gray-900 border border-gray-800" />
                <label for="remember" class="text-sm text-black">Keep me logged in</label>
            </div>
            <a href="{{ route('forgot-password') }}" wire:navigate.hover
                class="text-sm text-blue-400 hover:underline">Forgot password?</a>
        </div>
        <button type="submit" class="btn-primary px-4 py-2 w-full">
            <span wire:loading.remove wire:target="authenticate">Sign In</span>
            <x-spinner class="size-6" wire:loading wire:target="authenticate" />
        </button>
    </form>

    <div class="flex items-center justify-center gap-5 mt-4">
        <p class="text-xs text-gray-400 flex items-center gap-1">
            Already have an account? <a wire:navigate.hover href="{{ route('register') }}"
                class="text-blue-500 hover:text-blue-400 font-semibold">Register Here</a>
        </p>


    </div>

    <div class="p-6 xl:p-10 rounded-lg flex-1">
        <div class="flex items-center gap-4 mb-8">
            <div class="h-[1px] flex-1 bg-gray-200"></div>
            <span class="text-gray-400 text-sm font-light shrink-0">Or login with</span>
            <div class="h-[1px] flex-1 bg-gray-200"></div>
        </div>

        <div class="flex flex-col md:flex-row gap-4 w-full">
            <a href="{{ route('auth.google.redirect') }}"
                class="flex flex-1 items-center justify-center gap-3 py-3 px-4 border border-gray-300 rounded bg-white text-gray-700 hover:bg-gray-50 transition shadow-sm no-underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 48 48">
                    <path fill="#FFC107"
                        d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z" />
                    <path fill="#FF3D00"
                        d="m6.306 14.691 6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z" />
                    <path fill="#4CAF50"
                        d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z" />
                    <path fill="#1976D2"
                        d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z" />
                </svg>
                <span class="font-semibold text-lg">Google</span>
            </a>

            <a href="{{ route('auth.google.redirect') }}"
                class="flex flex-1 items-center justify-center gap-3 py-3 px-4 bg-[#1877F2] text-white rounded hover:bg-[#166fe5] transition shadow-sm no-underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 fill-current" viewBox="0 0 24 24">
                    <path
                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                </svg>
                <span class="font-semibold text-lg">Facebook</span>
            </a>

        </div>
    </div>

</div>
