<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memproses Berita – CheckFakta</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#FDFDFC] flex items-center justify-center px-6">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 text-center space-y-6">

        <!-- Icon -->
        <div class="flex justify-center">
            <svg class="w-16 h-16 text-orange-500 animate-spin"
                 xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10"
                        stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
        </div>

        <!-- Title -->
        <h1 class="text-2xl font-bold text-gray-800">
            Analisis Masih Dijalankan
        </h1>

        <!-- Explanation -->
        <p class="text-gray-600 leading-relaxed">
            Proses pengesahan berita ini mengambil masa yang lebih lama daripada biasa.
            Keputusan telah berjaya diproses dan disimpan.
        </p>

        <p class="text-gray-600">
            Sila semak keputusan anda di halaman
            <span class="font-semibold text-orange-600">Sejarah Semakan</span>.
        </p>

        <!-- Countdown -->
        <p class="text-sm text-gray-500">
            Anda akan dialihkan secara automatik dalam
            <span id="countdown" class="font-semibold text-gray-700">8</span> saat…
        </p>

        <!-- Manual button -->
        <a href="{{ route('news.history') }}"
           class="inline-block w-full px-6 py-3 bg-orange-600 text-white rounded-lg font-semibold shadow hover:bg-orange-700 transition">
            Pergi ke Sejarah Sekarang
        </a>
    </div>

    <!-- Redirect Script -->
    <script>
        let seconds = 8;
        const countdown = document.getElementById('countdown');

        const timer = setInterval(() => {
            seconds--;
            countdown.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(timer);
                window.location.href = "{{ route('news.history') }}";
            }
        }, 1000);
    </script>

</body>
</html>
