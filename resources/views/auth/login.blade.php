<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

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
            <label for="remember_me" class="flex items-center text-white">
                <input id="remember_me" type="checkbox" class="rounded bg-white border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm text-white dark:text-white">{{ __('Remember me') }}</span>
            </label>            
        </div>


        
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-white dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" 
    href="{{ route('password.request') }}" 
    style="color: white; transition: color 0.3s ease;" 
    onmouseover="this.style.color='rgb(255, 102, 0)'" 
    onmouseout="this.style.color='white'">
    {{ __('Forgot your password?') }}
</a>       
            @endif
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-white dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" 
            href="{{ route('register') }}" 
            style="color: white; transition: color 0.3s ease;" 
            onmouseover="this.style.color='rgb(255, 102, 0)';" 
            onmouseout="this.style.color='white';">
            {{ __('Registered?') }}
        </a>
        
        <x-primary-button class="ml-3" style="background-color:rgb(255, 102, 0); color: white; border: none; border-radius: 0.375rem; padding: 0.5rem 1rem; transition: background-color 0.3s ease, color 0.3s ease;" 
    onmouseover="this.style.backgroundColor='white'; this.style.color='rgb(255, 102, 0)';" 
    onmouseout="this.style.backgroundColor='rgb(255, 102, 0)'; this.style.color='white';">
    {{ __('Log in') }}
    </x-primary-button>

        
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: 
                    `<ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>`,
                    confirmButtonColor: '#ff6600',
                    confirmButtonText: 'Okay'
                });
            });
        </script>
    @endif
</x-guest-layout>
