{{-- <section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section> --}}

<section class="bg-white p-8 rounded-xl shadow border border-gray-200 space-y-6">
    <header>
        <h2 class="text-2xl font-bold text-orange-600">
            Padam Akaun
        </h2>

        <p class="mt-2 text-gray-600">
            Setelah akaun anda dipadam, semua data dan maklumat akan hilang secara kekal. 
            Pastikan anda telah menyimpan sebarang maklumat penting sebelum meneruskan.
        </p>
    </header>

    <!-- Delete Button -->
    <button
        x-data
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-6 py-3 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition"
    >
        Padam Akaun
    </button>

    <!-- Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-white rounded-xl">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-bold text-red-600 mb-2">
                Anda pasti mahu memadam akaun?
            </h2>

            <p class="text-gray-600">
                Setelah akaun dipadam, semua data akan hilang secara kekal. 
                Sila masukkan kata laluan anda untuk mengesahkan tindakan ini.
            </p>

            <!-- Password Input -->
            <div class="mt-6">
                <label for="password" class="font-semibold text-gray-700">Kata Laluan</label>

                <input 
                    id="password"
                    name="password"
                    type="password"
                    class="mt-2 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-red-500 focus:ring focus:ring-red-200"
                    placeholder="Masukkan kata laluan"
                >

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-600" />
            </div>

            <!-- Buttons -->
            <div class="mt-8 flex justify-end gap-3">
                <button 
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition"
                >
                    Batal
                </button>

                <button 
                    class="px-6 py-3 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition"
                >
                    Padam Akaun
                </button>
            </div>
        </form>
    </x-modal>
</section>
