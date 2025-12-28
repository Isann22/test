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

    <div class="w-50 max-w-md mx-auto p-6">



        <div class="relative flex items-center mb-8">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="flex-shrink mx-4 text-gray-400 text-sm font-light">Or login with</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <div class="flex gap-4">
            <button
                class="flex items-center justify-center gap-3 w-full py-2.5 border border-gray-300 rounded bg-white text-gray-700 hover:bg-gray-50 transition">
                <img src="https://www.gstatic.com/images/branding/product/1x/gsa_64dp.png" alt="Google"
                    class="w-7 h-7">
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

</div>
