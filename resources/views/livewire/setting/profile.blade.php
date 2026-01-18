<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    {{-- Page Header --}}
    <x-mary-header title="Account Settings" subtitle="Manage your profile information and security" separator />

    <div class="space-y-6">
        {{-- Profile Information Card --}}
        <x-mary-card title="Profile Information" subtitle="Update your account's profile information and email address."
            shadow separator>
            <form wire:submit="updateProfile" class="space-y-4">
                <x-mary-input label="Full Name" wire:model="name" placeholder="Enter your full name" icon="o-user"
                    required />

                <x-mary-input label="Email Address" wire:model="email" type="email"
                    placeholder="Enter your email address" icon="o-envelope" required />

                <x-mary-input label="Phone Number" wire:model="phone_number" placeholder="Enter your phone number"
                    icon="o-phone" />

                <x-slot:actions>
                    <x-mary-button label="Save Changes" type="submit" class="btn-primary" spinner="updateProfile"
                        icon="o-check" />
                </x-slot:actions>
            </form>
        </x-mary-card>

        {{-- Update Password Card --}}
        <x-mary-card title="Update Password" subtitle="Ensure your account is using a secure password." shadow
            separator>
            <form wire:submit="updatePassword" class="space-y-4">
                <x-mary-input label="Current Password" wire:model="current_password" type="password"
                    placeholder="Enter your current password" icon="o-lock-closed" required />

                <x-mary-input label="New Password" wire:model="password" type="password"
                    placeholder="Enter your new password" icon="o-key" required />

                <x-mary-input label="Confirm New Password" wire:model="password_confirmation" type="password"
                    placeholder="Confirm your new password" icon="o-key" required />

                <x-slot:actions>
                    <x-mary-button label="Update Password" type="submit" class="btn-primary" spinner="updatePassword"
                        icon="o-lock-closed" />
                </x-slot:actions>
            </form>
        </x-mary-card>
    </div>
</div>
