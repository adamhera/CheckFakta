{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Pengguna - CheckFakta</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen flex flex-col">

    <!-- Navbar (Sama seperti Dashboard) -->
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <a href="{{ route('dashboard') }}"
           class="text-2xl font-bold text-orange-600 hover:text-orange-700 transition px-3 py-2 rounded-lg border border-orange-600 hover:bg-orange-50">
            CheckFakta
        </a>

        <div class="relative">
            <button id="userMenuButton" 
                    class="flex items-center gap-2 px-4 py-2 border border-orange-600 text-orange-600 rounded-lg hover:bg-orange-50 transition">
                {{ Auth::user()->name }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 text-center hover:bg-gray-100">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-gray-700 text-center hover:bg-gray-100">Log Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Profile Hero -->
    <section class="relative bg-gray-900 text-white py-20 text-center rounded-b-3xl shadow-lg">
        <h1 class="text-4xl sm:text-5xl font-bold mb-4">Profil Pengguna</h1>
        <p class="text-lg sm:text-xl max-w-3xl mx-auto">
            Kemaskini maklumat akaun anda di sini.
        </p>
    </section>

    <!-- Profile Forms Section -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10 py-12">
        
        <!-- Update Profile Info -->
        <div class="p-6 sm:p-8 bg-white shadow-lg rounded-2xl hover:shadow-2xl transition">
            <h3 class="text-2xl font-semibold text-orange-600 mb-6">Kemaskini Maklumat Akaun</h3>
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="p-6 sm:p-8 bg-white shadow-lg rounded-2xl hover:shadow-2xl transition">
            <h3 class="text-2xl font-semibold text-orange-600 mb-6">Tukar Kata Laluan</h3>
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="p-6 sm:p-8 bg-white shadow-lg rounded-2xl hover:shadow-2xl transition">
            <h3 class="text-2xl font-semibold text-orange-600 mb-6">Padam Akaun</h3>
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="text-center py-6 text-gray-500 text-sm border-t border-gray-200">
        © {{ date('Y') }} CheckFakta. Semua Hak Terpelihara.
    </footer>

    <!-- Dropdown Script -->
    <script>
        document.getElementById('userMenuButton').addEventListener('click', function(){
            document.getElementById('userMenu').classList.toggle('hidden');
        });
    </script>

</body>
</html>
