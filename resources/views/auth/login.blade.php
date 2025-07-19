<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h1 class="text-2xl font-semibold text-center text-gray-800 dark:text-white my-6">
            Login 
        </h1>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        
<!-- Links -->
<div class="flex flex-col gap-4 mt-6">
    <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-400">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}"
               class="hover:text-gray-900 dark:hover:text-gray-100 transition">
                {{ __('Forgot your password?') }}
            </a>
        @endif

        <a href="{{ route('register') }}"
           class="hover:text-gray-900 dark:hover:text-gray-100 transition">
            {{ __('Don’t have an account?') }}
        </a>
    </div>

    <!-- login button -->
    <div>
        <x-primary-button class="w-full justify-center text-center">
            {{ __('Log in') }}
        </x-primary-button>
    </div>

</div>
        
    </form>

</x-guest-layout>
