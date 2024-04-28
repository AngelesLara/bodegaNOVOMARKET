<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" placeholder="Corrreo Electrónico" name="email" value="{{ old('email') }}"
                        tabindex="1" required autofocus>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                        @if (Route::has('password.request'))
                            <div class="float-right">
                                <a class="text-small" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            </div>
                        @endif
                    </div>
                    <x-text-input id="password" class="form-control" placeholder="Contraseña"  type="password" name="password" required
                        autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="btn btn-primary btn-lg btn-block">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
