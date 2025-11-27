{{-- <section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section> --}}

<section class="bg-white p-8 rounded-xl shadow border border-gray-200">
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-orange-600">
            Tukar Kata Laluan
        </h2>

        <p class="mt-2 text-gray-600">
            Pastikan akaun anda menggunakan kata laluan yang panjang dan selamat.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <label for="update_password_current_password" class="font-semibold text-gray-700">
                Kata Laluan Semasa
            </label>
            <input 
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="mt-2 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-orange-500 focus:ring focus:ring-orange-200"
                autocomplete="current-password"
            >
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-600" />
        </div>

        <!-- New Password -->
        <div>
            <label for="update_password_password" class="font-semibold text-gray-700">
                Kata Laluan Baharu
            </label>
            <input 
                id="update_password_password"
                name="password"
                type="password"
                class="mt-2 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-orange-500 focus:ring focus:ring-orange-200"
                autocomplete="new-password"
            >
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="update_password_password_confirmation" class="font-semibold text-gray-700">
                Sahkan Kata Laluan
            </label>
            <input 
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-2 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-orange-500 focus:ring focus:ring-orange-200"
                autocomplete="new-password"
            >
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-600" />
        </div>

        <!-- Save -->
        <div class="flex items-center gap-4">
            <button class="px-6 py-3 bg-orange-600 text-white rounded-lg shadow hover:bg-orange-700 transition">
                Simpan
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >
                    Disimpan.
                </p>
            @endif
        </div>
    </form>
</section>
