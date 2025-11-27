<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>CheckFakta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] flex flex-col min-h-screen">

    <!-- Navbar -->
    <!-- Navbar -->
    <header class="w-full bg-white shadow">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <!-- Logo sebagai button -->
            <a href="{{ url('/') }}" class="text-2xl font-bold text-orange-600 hover:text-orange-700 transition px-3 py-2 rounded-lg border border-orange-600 hover:bg-orange-50">
                CheckFakta
            </a>

            <nav class="flex items-center gap-4">
                <a href="#" class="px-4 py-2 bg-orange-600 text-white rounded-lg font-medium hover:bg-orange-700 transition">
                    Utama
                </a>
                <a href="{{ route('about') }}" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-orange-50 transition">
                    Tentang Kami
                </a>
                <a href="{{ route('rating') }}" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-orange-50 transition">
                    Penarafan
                </a>
                <a href="{{ route('contact') }}" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-orange-50 transition">
                    Hubungi Kami
                </a>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-lg font-medium border border-orange-600 text-orange-600 hover:bg-orange-50 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg font-medium border border-orange-600 text-orange-600 hover:bg-orange-50 transition">
                            Log Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg font-medium border border-orange-600 text-orange-600 hover:bg-orange-50 transition">
                            Daftar
                        </a>
                    @endauth
                @endif
            </nav>
        </div>
    </header>


    <!-- Hero Section -->
    <section class="relative bg-gray-900 text-white py-32 text-center">
        <h1 class="text-5xl font-bold mb-4">Jangan Sebar Melulu, CheckFakta Dulu</h1>
        <p class="text-xl mb-8 max-w-2xl mx-auto">
            Sahkan kebenaran berita dengan teknologi AI kami sebelum anda berkongsi.
        </p>
        
    </section>

    <br>
    <div class="grid md:grid-cols-3 gap-8">
        <!-- Step 1 -->
        <div class="bg-blue-50 p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('images/icons/upload.svg') }}" alt="Hantar Berita" class="w-16 h-16">
            </div>
            <h3 class="text-xl font-semibold text-blue-600 mb-2">Hantar Berita</h3>
            <p class="text-gray-600">
                Muat naik teks berita yang ingin disemak. Sistem menerima apa saja format teks.
            </p>
        </div>

        <!-- Step 2 -->
        <div class="bg-blue-50 p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('images/icons/brain-circuit.svg') }}" alt="Analisis AI & ML" class="w-16 h-16">
            </div>
            <h3 class="text-xl font-semibold text-blue-600 mb-2">Analisis AI & ML</h3>
            <p class="text-gray-600">
                Sistem menilai berita menggunakan model Machine Learning yang dilatih untuk mengenal pasti fakta sebenar dan palsu.
            </p>
        </div>

        <!-- Step 3 -->
        <div class="bg-blue-50 p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('images/icons/badge-check.svg') }}" alt="Terima Keputusann" class="w-16 h-16">
            </div>
            <h3 class="text-xl font-semibold text-blue-600 mb-2">Terima Keputusan</h3>
            <p class="text-gray-600">
                Hasil penilaian dipaparkan sebagai <em>Real</em>, <em>Fake</em>, atau <em>Unclear</em>. Kongsi dengan yakin!
            </p>
        </div>
    </div>

    
</div>




    <!-- Footer -->
    <footer class="text-center py-6 text-gray-500 text-sm border-t border-gray-200">
        © {{ date('Y') }} CheckFakta. Semua Hak Terpelihara.
    </footer>

</body>
</html>
