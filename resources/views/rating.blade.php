<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Penarafan Berita - CheckFakta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] flex flex-col min-h-screen">

    <!-- Navbar -->
    <header class="w-full bg-white shadow">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <a href="{{ url('/') }}" class="text-2xl font-bold text-orange-600 hover:text-orange-700 transition px-3 py-2 rounded-lg border border-orange-600 hover:bg-orange-50">
                CheckFakta
            </a>

            <nav class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="px-4 py-2 bg-orange-600 text-white rounded-lg font-medium hover:bg-orange-700 transition">
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
            </nav>
        </div>
    </header>

    <!-- Rating Page Content -->
    <section class="min-h-screen flex flex-col justify-center items-center bg-gray-50 px-6">
    <div class="max-w-3xl text-center">
        <h2 class="text-4xl font-bold text-gray-800 mb-6">Penarafan Berita</h2>
        <p class="text-lg text-gray-600 mb-12">
                Sistem kami menilai setiap berita dalam tiga kategori supaya anda tahu status fakta berita tersebut.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Real -->
                <div class="bg-green-50 p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('images/icons/real.svg') }}" alt="Real" class="w-16 h-16">
                    </div>
                    <h3 class="text-xl font-semibold text-green-600 mb-2">Benar</h3>
                    <p class="text-gray-600">
                        Berita telah disahkan sebagai fakta sebenar. Anda boleh kongsi dengan yakin.
                    </p>
                </div>

                <!-- Fake -->
                <div class="bg-red-50 p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('images/icons/fake.svg') }}" alt="Fake" class="w-16 h-16">
                    </div>
                    <h3 class="text-xl font-semibold text-red-600 mb-2">Palsu</h3>
                    <p class="text-gray-600">
                        Berita ini tidak benar dan boleh menimbulkan kekeliruan. Elakkan berkongsi.
                    </p>
                </div>

                <!-- Unclear -->
                <div class="bg-yellow-50 p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('images/icons/unclear.svg') }}" alt="Unclear" class="w-16 h-16">
                    </div>
                    <h3 class="text-xl font-semibold text-yellow-600 mb-2">Kurang Jelas</h3>
                    <p class="text-gray-600">
                        Berita ini tidak cukup maklumat untuk disahkan. Sila semak sumber lain sebelum berkongsi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-6 text-gray-500 text-sm border-t border-gray-200">
        © {{ date('Y') }} CheckFakta. Semua Hak Terpelihara.
    </footer>

</body>
</html>
