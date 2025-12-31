<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    use WithRateLimiting;

    public string $full_name;
    public string $email;
    public string $password;
    public string $password_confirmation;
    public string $phone;


    public function validateEmail()
    {

        try {
            $this->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

            ]);
            return true;
        } catch (ValidationException $exception) {
            Toaster::error($exception->getMessage());
            return;
        }
    }

    public function register()
    {
        try {
            $this->rateLimit(10, decaySeconds: 300);
        } catch (TooManyRequestsException $exception) {
            Toaster::error("You have made too many requests. Please try again in {$exception->minutesUntilAvailable} minutes.");
            return;
        }

        $this->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => [
                'required',
                'string',
                'regex:/^\+[1-9]\d{1,14}$/'
            ],

        ]);

        $attributes = [
            'name' => $this->full_name,
            'email' => $this->email,
            'password' => $this->password,
            'phone_number' => $this->phone,
        ];


        DB::beginTransaction();
        try {
            $user = User::create($attributes);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Toaster::error('An error occurred,');
        }

        Auth::login($user);

        event(new Registered($user));

        return redirect(route('verification.notice'))->success('Welcome to the ' . config('app.name') . '!');
    }

    public function render()
    {
        return view('livewire.auth.register')->title('Sign Up - ' . config('app.name'));
    }
}
