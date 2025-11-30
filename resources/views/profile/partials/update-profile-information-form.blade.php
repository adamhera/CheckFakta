{{-- <section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
            Maklumat Profil
        </h2>

        <p class="mt-2 text-gray-600">
            Kemas kini nama dan alamat emel akaun anda.
        </p>
    </header>

    <!-- Re-send verification -->
    {{-- <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form> --}}

    <!-- Profile Update Form -->
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <label for="name" class="font-semibold text-gray-700">Nama</label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                class="mt-2 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-orange-500 focus:ring focus:ring-orange-200"
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                autocomplete="name"
            >
            <x-input-error class="mt-2 text-red-600" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="font-semibold text-gray-700">Emel</label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                class="mt-2 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:border-orange-500 focus:ring focus:ring-orange-200"
                value="{{ old('email', $user->email) }}" 
                required 
                autocomplete="username"
            >
            <x-input-error class="mt-2 text-red-600" :messages="$errors->get('email')" />

            {{-- @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 bg-orange-50 p-4 rounded-lg border border-orange-200">
                    <p class="text-sm text-gray-700">
                        Emel anda belum disahkan.

                        <button form="send-verification" 
                            class="underline text-orange-600 font-medium hover:text-orange-700">
                            Klik di sini untuk hantar semula pautan pengesahan.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-green-600 text-sm font-semibold">
                            Pautan pengesahan baharu telah dihantar ke emel anda.
                        </p>
                    @endif
                </div>
            @endif --}}
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <button 
                class="px-6 py-3 bg-orange-600 text-white rounded-lg shadow hover:bg-orange-700 transition">
                Simpan
            </button>

            @if (session('status') === 'profile-updated')
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
