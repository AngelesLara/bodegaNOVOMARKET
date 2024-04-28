<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div class="form-group">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="form-control" type="password" name="password" required
                        autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button class="btn btn-primary btn-lg btn-block">
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
