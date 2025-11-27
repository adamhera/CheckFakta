<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Tentang Kami - CheckFakta</title>
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

    <!-- About Us Content -->
    <section class="min-h-screen flex flex-col justify-center items-center bg-[#FDFDFC] px-6 py-16">
        <div class="max-w-4xl text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-6">Tentang Kami</h2>
            <p class="text-lg text-gray-600 mb-12">
                CheckFakta ditubuhkan untuk membantu masyarakat membezakan berita sebenar daripada berita palsu.
                Kami menggunakan teknologi AI dan Pembelajaran Mesin untuk memastikan maklumat yang anda terima adalah tepat dan boleh dipercayai.
            </p>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Misi -->
                <div class="bg-blue-50 p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('images/icons/list-check.svg') }}" alt="Misi" class="w-16 h-16">
                    </div>
                    <h3 class="text-xl font-semibold text-blue-600 mb-2">Misi Kami</h3>
                    <p class="text-gray-600">
                        Menyediakan platform semakan fakta yang mudah digunakan dan dipercayai oleh semua lapisan masyarakat.
                    </p>
                </div>

                <!-- Visi -->
                <div class="bg-blue-50 p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('images/icons/telescope.svg') }}" alt="Visi" class="w-16 h-16">
                    </div>
                    <h3 class="text-xl font-semibold text-blue-600 mb-2">Visi Kami</h3>
                    <p class="text-gray-600">
                        Menjadi rujukan utama rakyat Malaysia untuk berita yang benar dan dapat dipercayai.
                    </p>
                </div>

                <!-- Nilai -->
                <div class="bg-blue-50 p-8 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105">
                    <div class="flex justify-center mb-4">
                        <img src="{{ asset('images/icons/message-circle-heart.svg') }}" alt="Nilai" class="w-16 h-16">
                    </div>
                    <h3 class="text-xl font-semibold text-blue-600 mb-2">Nilai Kami</h3>
                    <p class="text-gray-600">
                        Ketelusan, integriti, dan inovasi teknologi dalam setiap penilaian fakta yang kami lakukan.
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
