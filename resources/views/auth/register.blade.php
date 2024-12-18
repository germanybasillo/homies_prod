<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" placeholder="Please Use Your Real Email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Number Field -->
        <div id="number-field" class="mt-4" style="display: none;">
            <x-input-label for="number" :value="__('Number')" />
            <x-text-input id="number" class="block mt-1 w-full" type="text" name="number" placeholder="Please Use Your Real Number Gcash" value="{{ old('number') }}" autocomplete="number" />
            <x-input-error :messages="$errors->get('number')" class="mt-2" />
	</div>

       <!-- Document Field -->
    <div id="document-field" class="mt-4" style="display: none;">
        <x-input-label for="document" :value="__('Your Permit License')" />
        <x-text-input id="document" class="block mt-1 w-full" type="file" name="document" placeholder="Please Upload your Permit" value="{{ old('document') }}" autocomplete="document" />
        @if(old('document'))
            <div class="mt-2">
                <a href="{{ asset('storage/' . old('document')) }}" target="_blank" class="text-blue-500">View Document</a>
            </div>
        @endif
        <x-input-error :messages="$errors->get('document')" class="mt-2" />
    </div>

    <!-- Valid Id Field -->
    <div id="valid_id-field" class="mt-4" style="display: none;">
        <x-input-label for="valid_id" :value="__('Valid Id')" />
        <x-text-input id="valid_id" class="block mt-1 w-full" type="file" name="valid_id" placeholder="Please Upload your Id" value="{{ old('valid_id') }}" autocomplete="valid_id" />
        @if(old('valid_id'))
            <div class="mt-2">
                <a href="{{ asset('storage/' . old('valid_id')) }}" target="_blank" class="text-blue-500">View Valid ID</a>
            </div>
        @endif
        <x-input-error :messages="$errors->get('valid_id')" class="mt-2" />
    </div>

	<!-- User Type -->
@if (!$adminExists)
    <div class="mt-4">
        <x-input-label for="user_type" :value="__('User Type')" />
        <select id="user_type" name="user_type" class="block mt-1 w-full" required>
            <option value="" disabled selected>{{ __('Select user type') }}</option>
            <option value="tenant">{{ __('Tenant') }}</option>
            <option value="rental_owner">{{ __('Rental Owner') }}</option>
            <option value="admin">{{ __('Admin') }}</option> <!-- Corrected value -->
        </select>
        <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
    </div>
@else
    <div class="mt-4">
        <x-input-label for="user_type" :value="__('User Type')" />
        <select id="user_type" name="user_type" class="block mt-1 w-full" required>
            <option value="" disabled selected>{{ __('Select user type') }}</option>
            <option value="tenant">{{ __('Tenant') }}</option>
            <option value="rental_owner">{{ __('Rental Owner') }}</option>
        </select>
        <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
    </div>
    @endif


<div class="col-md-8 offset-md-2" style="display:none">
   <div class="form-group">
           <label>Status</label>
             <select class="form-control" name="status">
        <option value="pending" style="color:red">Pending</option>
     <option value="approaved" style="color:yellow">Approved</option>
    </select>
     </div>
  </div>


            <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-white dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" 
            href="{{ route('login') }}" 
            style="color: white; transition: color 0.3s ease;" 
            onmouseover="this.style.color='rgb(255, 102, 0)';" 
            onmouseout="this.style.color='white';">
            {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-3" style="background-color: rgb(255, 102, 0); color: white; border: none; border-radius: 0.375rem; padding: 0.5rem 1rem; transition: background-color 0.3s ease, color 0.3s ease;" 
            onmouseover="this.style.backgroundColor='white'; this.style.color='rgb(255, 102, 0)';" 
            onmouseout="this.style.backgroundColor='rgb(255, 102, 0)'; this.style.color='white';">
            {{ __('Register') }}
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

   <script>
    document.getElementById('user_type').addEventListener('change', function() {
        var userType = this.value;
        var numberField = document.getElementById('number-field');
        var documentField = document.getElementById('document-field');
        var valid_idField = document.getElementById('valid_id-field');

        if (userType === 'rental_owner') {
            numberField.style.display = 'block';
            documentField.style.display = 'block';
            valid_idField.style.display = 'block';
        } else {
            numberField.style.display = 'none';
            documentField.style.display = 'none';
            valid_idField.style.display = 'none';
        }
    });
</script>

</x-guest-layout>
