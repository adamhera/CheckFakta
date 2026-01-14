{{--
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="bg-[#FDFDFC] min-h-screen py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-gray-900 dark:text-gray-100 mb-6">
                    You're logged in!
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('news.create') }}" class="px-4 py-2 bg-orange-600 text-white rounded-lg shadow hover:bg-orange-700 transition">
                        New Detection
                    </a>
                    <a href="{{ route('news.history') }}" class="px-4 py-2 bg-orange-600 text-white rounded-lg shadow hover:bg-orange-700 transition">
                        View History
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
--}}


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CheckFakta Dashboard</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen flex flex-col">

    <!-- Navbar Header CheckFakta + Dropdown User -->
    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center">
        <!-- Button CheckFakta -->
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

    <!-- Hero Section / Welcome Besar -->
    <section class="relative bg-gray-900 text-white py-32 text-center rounded-b-3xl shadow-lg">
        <h1 class="text-5xl sm:text-6xl font-bold mb-6">Selamat Datang ke Dashboard</h1>
        <p class="text-xl sm:text-2xl max-w-3xl mx-auto mb-8">
            Anda telah log masuk sebagai {{ Auth::user()->name }}. Semak dan sahkan berita dengan mudah menggunakan sistem kami.
        </p>
        <div class="flex justify-center gap-6">
    <a href="{{ route('news.create') }}" 
       class="px-8 py-4 bg-orange-600 text-white text-lg font-semibold rounded-lg shadow hover:bg-orange-700 transition">
        Semak Berita 
    </a>
    <a href="{{ route('news.history') }}" 
       class="px-8 py-4 bg-orange-600 text-white text-lg font-semibold rounded-lg shadow hover:bg-orange-700 transition">
        Lihat Semakan Terdahulu
    </a>
</div>

    </section>
    <br>
    <!-- Latest News Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Berita Terkini</h2>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach ($latestNews as $news)
                @php
                    $rawDate = trim($news['date']);
                    $rawDate = preg_replace('/[\x00-\x1F\x7F]/u', '', $rawDate);

                    try {
                        $formattedDate = \Carbon\Carbon::createFromFormat('d/m/Y', $rawDate)->format('d M Y');
                    } catch (\Exception $e) {
                        $formattedDate = \Carbon\Carbon::parse($rawDate)->format('d M Y');
                    }
                @endphp

                <div class="bg-gray-50 p-6 rounded-xl shadow hover:shadow-xl transition border border-gray-200">
                    <h3 class="font-semibold text-lg mb-2 text-blue-700">{{ $news['title'] }}</h3>
                    <p class="text-sm text-gray-500 mb-4">{{ $formattedDate }}</p>
                    <p class="text-gray-700 text-sm mb-4">{{ \Illuminate\Support\Str::limit($news['body'], 120) }}</p>
                    <a href="{{ $news['link'] }}" target="_blank" class="text-orange-600 hover:text-orange-700 font-medium">
                        Baca Lanjut →
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

    <br>
    <!-- Fun / Motivational Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-orange-600 mb-8 text-center">Fakta & Motivasi</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="bg-orange-100 p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-semibold text-lg mb-2">Tahukah Anda?</h3>
                    <p class="text-gray-800">60% berita viral di media sosial tidak disemak terlebih dahulu!</p>
                </div>
                <div class="bg-orange-100 p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-semibold text-lg mb-2">Tips Cepat</h3>
                    <p class="text-gray-800">Selalu semak sumber berita sebelum berkongsi.</p>
                </div>
                <div class="bg-orange-100 p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-semibold text-lg mb-2">Fakta Menarik</h3>
                    <p class="text-gray-800">Berita yang kurang jelas lebih mudah tersebar – gunakan CheckFakta untuk semak!</p>
                </div>
                <div class="bg-orange-100 p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-semibold text-lg mb-2">Motivasi</h3>
                    <p class="text-gray-800">Menjadi pengguna bijak membantu orang lain tidak tertipu dengan berita palsu.</p>
                </div>
                <div class="bg-orange-100 p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-semibold text-lg mb-2">Fun Fact</h3>
                    <p class="text-gray-800">Berita palsu lebih cepat tersebar 6x berbanding berita benar!</p>
                </div>
                <div class="bg-orange-100 p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="font-semibold text-lg mb-2">Reminder</h3>
                    <p class="text-gray-800">Sentiasa semak sebelum klik share!</p>
                </div>
            </div>
        </div>
    </section>

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



