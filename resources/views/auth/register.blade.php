<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="firstname" value="{{ __('Firstname') }}" />
                <x-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            </div>
            <div>
                <x-label for="insertion" value="{{ __('Insertion') }}" />
                <x-input id="insertion" class="block mt-1 w-full" type="text" name="insertion" :value="old('insertion')" autofocus autocomplete="insertion" />
            </div>


            <div class="mt-4">
                <x-label for="lastname" value="{{ __('Lastname') }}" />
                <x-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />

            </div>
            <div class="mt-4">
                <x-label for="city" value="{{ __('City') }}" />
                <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required autofocus autocomplete="city" />



            <div class="mt-4">
                <x-label for="email " value="{{ __('Email ') }}" />
                <x-input id="email " class="block mt-1 w-full" type="email " name="email " :value="old('email ')" required autocomplete="email " />
            </div>

            <div class="mt-4">
                <x-label for="phonenumber" value="{{ __('Phonenumber') }}" />
                <x-input id="phonenumber" class="block mt-1 w-full" type="number" name="phonenumber" :value="old('phonenumber')" required autofocus autocomplete="phonenumber" />

            </div>
            <div class="mt-4">
                <x-label for="dateofbirth" value="{{ __('Dateofbirth') }}" />
                <x-input id="dateofbirth" class="block mt-1 w-full" type="date" name="dateofbirth" :value="old('dateofbirth')" required autofocus autocomplete="dateofbirth" />

            </div>

                <div class="mt-4">
                    <x-label for="gender" value="{{ __('Gender') }}" />
                    <select id="gender" class="block mt-1 w-full" name="gender" required autofocus autocomplete="gender">
                        <option value="1" {{ old('gender') == 'man' ? 'selected' : '' }}>Man</option>
                        <option value="0" {{ old('gender') == 'vrouw' ? 'selected' : '' }}>Vrouw</option>
                    </select>
                </div>


                <div class="mt-4">
                    <x-label for="straight" value="{{ __('straight') }}" />
                    <select id="straight" class="block mt-1 w-full" name="straight" required autofocus autocomplete="straight">
                        <option value="1" {{ old('straight') == 'ja' ? 'selected' : '' }}>Ja</option>
                        <option value="0" {{ old('straight') == 'nee' ? 'selected' : '' }}>Nee</option>
                    </select>
                </div>



                <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>

            </div>
        </form>


    </x-authentication-card>
</x-guest-layout>
