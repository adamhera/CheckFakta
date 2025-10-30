{{--}}
<x-app-layout>
    <div class="container">
        <h2>My Detection History</h2>

        @if($histories->isEmpty())
            <p>No history yet.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>News Text</th>
                        <th>Result</th>
                        <th>Detected At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $history)
                        <tr>
                            <td>{{ $history->history_id }}</td>
                            <td>{{ $history->news_text }}</td>
                            <td>{{ $history->result }}</td>
                            <td>{{ $history->detected_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sejarah Deteksi - CheckFakta</title>
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

    <!-- Hero Section / History -->
    <section class="relative bg-gray-900 text-white py-32 text-center rounded-b-3xl shadow-lg">
        <h1 class="text-5xl sm:text-6xl font-bold mb-6">Sejarah Deteksi Anda</h1>
        <p class="text-xl sm:text-2xl max-w-3xl mx-auto mb-8">
            Semak semua berita yang telah anda hantar untuk pengesahan.
        </p>
        <div class="flex justify-center gap-6">
            <a href="{{ route('news.create') }}" 
               class="px-8 py-4 bg-orange-600 text-white text-lg font-semibold rounded-lg shadow hover:bg-orange-700 transition">
                Hantar Berita Baru
            </a>
        </div>
    </section>

    <!-- Table History -->
    <div class="flex-grow py-12">
        <div class="max-w-6xl mx-auto px-6 bg-white rounded-xl shadow p-8 mt-8">
            @if($histories->isEmpty())
                <p class="text-gray-600 text-center">Tiada sejarah deteksi setakat ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                        <thead class="bg-orange-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">ID</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Berita</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Keputusan</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Tarikh Dikesan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($histories as $history)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $history->history_id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $history->news_text }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $history->result }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $history->detected_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
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
