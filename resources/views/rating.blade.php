<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Penarafan Berita - CheckFakta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<section class="py-12 bg-gray-50 px-6">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Penarafan Berita</h2>
        <p class="text-md text-gray-600 mb-8">
            Sistem kami menilai setiap berita dalam tiga kategori supaya anda tahu status fakta berita tersebut.
        </p>

        <div class="grid md:grid-cols-3 gap-6">

            <!-- Real -->
            <div class="bg-green-50 p-6 rounded-xl shadow hover:shadow-xl transition duration-300">
                <div class="flex justify-center mb-3">
                    <img src="{{ asset('images/icons/real.svg') }}" alt="Real" class="w-14 h-14">
                </div>
                <h3 class="text-lg font-semibold text-green-600 mb-2">Benar</h3>
                <p class="text-gray-600 text-sm">
                    Berita telah disahkan sebagai fakta sebenar. Anda boleh kongsi dengan yakin.
                </p>
            </div>

            <!-- Fake -->
            <div class="bg-red-50 p-6 rounded-xl shadow hover:shadow-xl transition duration-300">
                <div class="flex justify-center mb-3">
                    <img src="{{ asset('images/icons/fake.svg') }}" alt="Fake" class="w-14 h-14">
                </div>
                <h3 class="text-lg font-semibold text-red-600 mb-2">Palsu</h3>
                <p class="text-gray-600 text-sm">
                    Berita ini tidak benar dan boleh menimbulkan kekeliruan. Elakkan berkongsi.
                </p>
            </div>

            <!-- Unclear -->
            <div class="bg-yellow-50 p-6 rounded-xl shadow hover:shadow-xl transition duration-300">
                <div class="flex justify-center mb-3">
                    <img src="{{ asset('images/icons/unclear.svg') }}" alt="Unclear" class="w-14 h-14">
                </div>
                <h3 class="text-lg font-semibold text-yellow-600 mb-2">Kurang Jelas</h3>
                <p class="text-gray-600 text-sm">
                    Berita ini tidak cukup maklumat untuk disahkan. Sila semak sumber lain sebelum berkongsi.
                </p>
            </div>

        </div>
    </div>
</section>

<!-- Confusion Matrix Section -->
<div class="mt-16 text-center px-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">Analisis Ketepatan Sistem</h2>
    <p class="text-gray-600 mb-10 max-w-3xl mx-auto">
        Berikut ialah matriks kekeliruan (Confusion Matrix) bagi model pengesanan berita palsu kami.
        Ia menunjukkan ketepatan ramalan bagi kategori <span class="font-semibold">Benar</span>,
        <span class="font-semibold">Palsu</span>, dan <span class="font-semibold">Kurang Jelas</span>.
    </p>

    <!-- Confusion Matrix Table -->
    <div class="overflow-x-auto flex justify-center">
        <table class="border-collapse shadow-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="border px-6 py-3"></th>
                    <th class="border px-6 py-3 font-semibold">Diramal: Palsu</th>
                    <th class="border px-6 py-3 font-semibold">Diramal: Benar</th>
                    <th class="border px-6 py-3 font-semibold">Diramal: Kurang Jelas</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                <tr>
                    <td class="border px-6 py-3 font-semibold bg-gray-100">Sebenar: Palsu</td>
                    <td class="border px-6 py-3 bg-green-100 font-bold">46</td>
                    <td class="border px-6 py-3 bg-red-100">1</td>
                    <td class="border px-6 py-3 bg-yellow-50">0</td>
                </tr>
                <tr>
                    <td class="border px-6 py-3 font-semibold bg-gray-100">Sebenar: Benar</td>
                    <td class="border px-6 py-3 bg-red-100">1</td>
                    <td class="border px-6 py-3 bg-green-100 font-bold">51</td>
                    <td class="border px-6 py-3 bg-yellow-50">0</td>
                </tr>
                <tr>
                    <td class="border px-6 py-3 font-semibold bg-gray-100">Sebenar: Kurang Jelas</td>
                    <td class="border px-6 py-3 bg-yellow-50">0</td>
                    <td class="border px-6 py-3 bg-red-100">3</td>
                    <td class="border px-6 py-3 bg-green-100 font-bold">95</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Performance Summary Cards -->
    <div class="grid md:grid-cols-3 gap-6 mt-12 max-w-5xl mx-auto text-left">
        <div class="bg-blue-50 p-6 rounded-xl shadow border border-blue-200">
            <h3 class="text-blue-700 font-bold text-lg mb-2">Precision</h3>
            <p class="text-gray-600">Kemampuan model untuk tidak menandakan berita benar sebagai palsu. <span class="font-semibold">Precision: 94%</span></p>
        </div>
        <div class="bg-green-50 p-6 rounded-xl shadow border border-green-200">
            <h3 class="text-green-700 font-bold text-lg mb-2">Recall</h3>
            <p class="text-gray-600">Kemampuan model untuk mengenal pasti semua berita dari kategori sebenar. <span class="font-semibold">Recall: 95%</span></p>
        </div>
        <div class="bg-yellow-50 p-6 rounded-xl shadow border border-yellow-200">
            <h3 class="text-yellow-700 font-bold text-lg mb-2">Accuracy</h3>
            <p class="text-gray-600">Ketepatan keseluruhan model dalam meramalkan semua kategori. <span class="font-semibold">Accuracy: 96%</span></p>
        </div>
    </div>

</div>

<!-- Footer -->
<footer class="text-center py-6 text-gray-500 text-sm border-t border-gray-200 mt-auto">
    © {{ date('Y') }} CheckFakta. Semua Hak Terpelihara.
</footer>


</body>
</html>
