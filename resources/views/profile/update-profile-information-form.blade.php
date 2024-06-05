<div>
    <x-form-section submit="updateProfileInformation">
        <x-slot name="title">
            {{ __('Profile Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update your account\'s profile information and email address.') }}
        </x-slot>

        <x-slot name="form">

            <div class="col-span-6 sm:col-span-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <!-- Name -->
                        <x-label for="firstname" value="{{ __('First Name') }}"/>
                        <x-input id="firstname" type="text" class="mt-1 block w-full" wire:model="state.firstname"
                                 required
                                 autocomplete="firstname"/>
                        <x-input-error for="name" class="mt-2"/>
                    </div>
                    <div>
                        <!-- Insertion -->
                        <x-label for="insertion" value="{{ __('Insertion') }}"/>
                        <x-input id="insertion" type="text" class="mt-1 block w-full" wire:model="state.insertion"
                                 autocomplete="insertion"/>
                        <x-input-error for="insertion" class="mt-2"/>
                    </div>
                </div>
            </div>

            <!-- Last Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="lastname" value="{{ __('Last Name') }}"/>
                <x-input id="lastname" type="text" class="mt-1 block w-full" wire:model="state.lastname" required
                         autocomplete="lastname"/>
                <x-input-error for="name" class="mt-2"/>
            </div>

            <!-- city -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="city" value="{{ __('City') }}"/>
                <x-input id="city" type="text" class="mt-1 block
            w-full" wire:model="state.city" required autocomplete="city"/>
                <x-input-error for="city" class="mt-2"/>
            </div>

            <!-- phonenumber -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="phonenumber" value="{{ __('Phone Number') }}"/>
                <x-input id="phonenumber" type="text" class="mt-1 block w-full" wire:model="state.phonenumber" required
                         autocomplete="phonenumber"/>
                <x-input-error for="phonenumber" class="mt-2"/>
            </div>


            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="email" value="{{ __('Email') }}"/>
                <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required
                         autocomplete="email"/>
                <x-input-error for="email" class="mt-2"/>

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                    <p class="text-sm mt-2 dark:text-white">
                        {{ __('Your email address is unverified.') }}

                        <button type="button"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                wire:click.prevent="sendEmailVerification">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if ($this->verificationLinkSent)
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                @endif
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled" wire:target="">
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-form-section>

    <x-section-border/>

    <x-form-section submit="updateProfileInformation">
        <x-slot name="title">
            {{ __('Opt Out') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Opt out of email notifications.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <div class="row flex">
                    @if($state['opt_out'] == 0)
                        <input type="radio" id="opt_out" name="opt_out" value="1" wire:model="state.opt_out">
                        <p class="text-sm text-green-600 dark:text-green-400 pl-4">
                            You are currently receiving email
                            notifications.
                        </p>
                    @else
                        <input type="radio" id="opt_out" name="opt_out" value="0" wire:model="state.opt_out">
                        <p class="text-sm text-red-600 dark:text-red-400 pl-4">
                            You have opted out of email
                            notifications.
                        </p>
                    @endif
                </div>
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled" wire:target="">
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-form-section>
</div>
