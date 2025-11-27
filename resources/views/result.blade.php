{{-- <x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <h2 class="text-2xl font-bold mb-6">📰 Detection Result</h2>

        <div class="bg-white shadow-md rounded-lg p-6">
            <p class="mb-4">
                <strong>News Text:</strong><br>
                <span class="text-gray-700">{{ $history->news_text }}</span>
            </p>

            <p class="mb-4">
                <strong>Result:</strong><br>
                @if(strtolower($history->result) === 'fake')
                    <span class="text-red-600 font-bold text-lg">Fake ❌</span>
                @elseif(strtolower($history->result) === 'real')
                    <span class="text-green-600 font-bold text-lg">Real ✅</span>
                @elseif(strtolower($history->result) === 'precaution')
                    <span class="text-yellow-600 font-bold text-lg">Precaution ⚠️</span>
                @elseif(strtolower($history->result) === 'unclear')
                    <span class="text-gray-800 font-bold text-lg">Unclear ❓</span>
                @else
                    <span class="text-gray-600 font-bold text-lg">{{ $history->result }}</span>
                @endif

                @if(isset($history->svm_confidence))
                    <span class="ml-2 text-gray-600 text-sm">
                        (Confidence: {{ number_format($history->svm_confidence * 100, 2) }}%)
                    </span>
                @endif
            </p>

            <p>
                <strong>Detected At:</strong><br>
                <span class="text-gray-600">{{ $history->detected_at }}</span>
            </p>
        </div> --}}

        {{-- 🧠 New Semantic Similarity Section --}}
        {{-- @if(!empty($similarities))
            <div class="mt-8 bg-gray-50 shadow-sm rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4">🔍 Most Similar Verified Facts</h3>
                <ul class="space-y-3">
                    @foreach($similarities as $item)
                        <li class="border-b pb-3">
                            <p class="font-medium text-gray-800">
                                {{ ucfirst($item['fact_title']) }}
                            </p>
                            <p class="text-sm text-gray-600">
                                Label: 
                                @if(strtolower($item['fact_label']) === 'real')
                                    <span class="text-green-600 font-semibold">Real ✅</span>
                                @elseif(strtolower($item['fact_label']) === 'fake')
                                    <span class="text-red-600 font-semibold">Fake ❌</span>
                                @else
                                    <span class="text-gray-600 font-semibold">{{ $item['fact_label'] }}</span>
                                @endif
                                | Similarity: {{ number_format($item['similarity'], 2) }}
                            </p> --}}

                            {{-- ✅ Add this section --}}
                            {{-- @php
                                $link = $item['fact_link'] ?? 'https://sebenarnya.my';
                            @endphp
                            <a href="{{ $link }}" target="_blank"
                               class="inline-block mt-2 text-blue-600 hover:underline font-medium">
                               🔗 Read Source
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('news.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Check Another News
            </a>

            <a href="{{ route('news.history') }}" 
               class="ml-3 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                View History
            </a>
        </div>
    </div>
</x-app-layout> --}}


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CheckFakta Detection Result</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen flex flex-col">

    <!-- Navbar Header CheckFakta + Dropdown User -->
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

    <!-- Page Header -->
    <section class="py-12 text-center bg-gray-50 shadow rounded-b-3xl">
        <h1 class="text-4xl sm:text-5xl font-bold mb-2 text-orange-600">📰 Keputusan Deteksi</h1>
        <p class="text-gray-700 text-lg">Hasil pengesanan berita anda telah tersedia di bawah.</p>
    </section>

    <div class="max-w-5xl mx-auto px-6 py-12 space-y-8 flex-1">

        <!-- News Text & Result Card -->
        <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
            <p class="mb-4">
                <strong>Teks Berita:</strong><br>
                <span class="text-gray-700">{{ $history->news_text }}</span>
            </p>

            <p class="mb-4">
                <strong>Keputusan:</strong><br>
                @if(strtolower($history->result) === 'fake')
                    <span class="text-red-600 font-bold text-lg">Palsu ❌</span>
                @elseif(strtolower($history->result) === 'real')
                    <span class="text-green-600 font-bold text-lg">Benar ✅</span>
                @elseif(strtolower($history->result) === 'precaution')
                    <span class="text-yellow-600 font-bold text-lg">Berhati-hati ⚠️</span>
                @elseif(strtolower($history->result) === 'unclear')
                    <span class="text-gray-800 font-bold text-lg">Tidak Jelas ❓</span>
                @else
                    <span class="text-gray-600 font-bold text-lg">{{ $history->result }}</span>
                @endif

                @if(isset($history->svm_confidence))
                    <span class="ml-2 text-gray-600 text-sm">
                        (Confidence: {{ number_format($history->svm_confidence * 100, 2) }}%)
                    </span>
                @endif
            </p>

            <p>
                <strong>Waktu Deteksi:</strong><br>
                <span class="text-gray-600">{{ $history->detected_at }}</span>
            </p>
        </div>

        <!-- Similar Facts Section -->
        @if(!empty($similarities))
            <div class="bg-gray-50 shadow-lg rounded-xl p-6 border border-gray-200">
                <h3 class="text-2xl font-semibold text-orange-600 mb-6 text-center">🔍 Fakta Disahkan Paling Serupa</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($similarities as $item)
                        @php
                            $link = $item['fact_link'] ?? 'https://sebenarnya.my';
                        @endphp
                        <div class="bg-white rounded-xl shadow p-4 border border-gray-200 hover:shadow-xl transition">
                            <p class="font-semibold text-gray-800 mb-2">{{ ucfirst($item['fact_title']) }}</p>
                            <p class="text-sm text-gray-600 mb-2">
                                Label: 
                                @if(strtolower($item['fact_label']) === 'real')
                                    <span class="text-green-600 font-semibold">Benar ✅</span>
                                @elseif(strtolower($item['fact_label']) === 'fake')
                                    <span class="text-red-600 font-semibold">Palsu ❌</span>
                                @else
                                    <span class="text-gray-600 font-semibold">{{ $item['fact_label'] }}</span>
                                @endif
                                | Similarity: {{ number_format($item['similarity'], 2) }}
                            </p>
                            <a href="{{ $link }}" target="_blank"
                               class="text-orange-600 hover:text-orange-700 font-medium inline-block mt-2">
                               🔗 Baca Sumber
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('news.create') }}" 
               class="px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg shadow transition">
               Semak Berita Lain
            </a>
            <a href="{{ route('news.history') }}" 
               class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow transition">
               Lihat Sejarah
            </a>
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

