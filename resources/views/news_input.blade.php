{{--}}
<x-app-layout>
    <div class="py-6 max-w-4xl mx-auto">
        <h2 class="text-2xl font-semibold mb-4">Enter News Text</h2>

        <form action="{{ route('news.store') }}" method="POST">
            @csrf
            <textarea name="news_text" rows="5" class="w-full border rounded p-2" placeholder="Enter news..."></textarea>

            <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                Submit
            </button>
        </form>
    </div>
</x-app-layout>
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hantar Berita - CheckFakta</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen flex flex-col">

    <!-- Navbar Header CheckFakta + Dropdown User -->
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <a href="{{ route('dashboard') }}" 
           class="text-2xl font-bold text-orange-600 hover:text-orange-700 transition px-3 py-2 rounded-lg border border-orange-600 hover:bg-orange-50">
            CheckFakta
        </a>

        <!-- Dropdown User -->
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

    <!-- Hero Section / Input -->
    <section class="relative bg-gray-900 text-white py-32 text-center rounded-b-3xl shadow-lg">
    <h1 class="text-5xl sm:text-6xl font-bold mb-6">Semak Berita</h1>
    <p class="text-xl sm:text-2xl max-w-3xl mx-auto mb-8">
        Masukkan teks berita yang ingin disahkan menggunakan sistem kami.
    </p>

</section>

    <!-- Form Input -->
    <div class="flex-grow py-12">
        <div class="max-w-3xl mx-auto px-6 bg-white rounded-xl shadow p-8 mt-8">
            <form action="{{ route('news.store') }}" method="POST">
                @csrf
                <label for="news_text" class="block text-gray-700 font-medium mb-2">Teks Berita</label>
                <textarea id="news_text" name="news_text" rows="6" 
                          class="w-full border border-gray-300 rounded-lg p-4 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                          placeholder="Masukkan berita di sini..."></textarea>

                <button type="submit" 
                        class="mt-6 px-6 py-3 bg-orange-600 text-white rounded-lg shadow hover:bg-orange-700 transition text-lg font-semibold">
                    Hantar
                </button>

                <a href="{{ route('news.history') }}" 
                   class="px-6 py-3 bg-orange-100 text-orange-600 rounded-lg shadow hover:bg-orange-200 transition text-lg font-semibold text-center">
                    Lihat Sejarah
                </a>
            </form>
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
