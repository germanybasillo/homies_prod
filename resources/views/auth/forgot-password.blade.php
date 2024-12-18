<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400" style="color: white">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button style="background-color: rgb(255, 102, 0); color: white; transition: background-color 0.3s ease, color 0.3s ease;" 
            onmouseover="this.style.color='rgb(255, 102, 0)'; this.style.backgroundColor='white';" 
            onmouseout="this.style.color='white'; this.style.backgroundColor='rgb(255, 102, 0)';">
            {{ __('Email Password Reset Link') }}
        </x-primary-button>
        </div>
    </form>
</x-guest-layout>