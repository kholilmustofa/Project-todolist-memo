<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <!-- Email Address or Username {User Credentials}-->
        <div>
            <x-input-label for="user_cred" :value="__('Email or Username')" />
            <x-text-input id="user_cred" class="block mt-1 w-full" type="text" name="user_cred" :value="old('user_cred')"
                required autofocus autocomplete="user_cred" />
            <x-input-error :messages="$errors->get('user_cred')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="label">
                <input id="remember_me" type="checkbox"
                    class="checkbox checkbox-sm checkbox-secondary border-neutral rounded-sm bg-base-300" name="remember">
                <span class="text-sm hover:text-primary">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="label text-sm hover:text-primary"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
