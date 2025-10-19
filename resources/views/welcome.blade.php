<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CheckFakta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex flex-col min-h-screen">

    <!-- Header (from Breeze) -->
    <header class="w-full lg:max-w-5xl mx-auto text-sm mb-6 mt-4 px-4">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="inline-block px-5 py-1.5 border border-[#19140035] dark:border-[#3E3E3A] rounded-sm hover:border-[#1915014a] text-sm">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 border border-transparent hover:border-[#19140035] rounded-sm text-sm">
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 border border-[#19140035] dark:border-[#3E3E3A] rounded-sm hover:border-[#1915014a] text-sm">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <!-- Hero Section -->
    <section class="flex flex-col items-center justify-center text-center py-20 bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
        <h1 class="text-4xl font-bold mb-4">Welcome to CheckFakta</h1>
        <p class="text-lg mb-8 max-w-xl">Your trusted source for verifying news authenticity using AI technology.</p>
        <a href="{{ route('news.create') }}"
           class="bg-white text-blue-600 font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition">
           Check News
        </a>
    </section>

    <!-- Latest Verified News -->
    <section class="py-12 px-6 flex-1">
        <h2 class="text-2xl font-bold mb-6 text-center">Latest Verified News</h2>

        @if($latestNews->count() > 0)
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @foreach($latestNews as $news)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                        <img src="{{ asset('images/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-1">{{ $news->title }}</h3>
                            <p class="text-gray-500 text-sm mb-2">
                                {{ \Carbon\Carbon::parse($news->created_at)->format('M d, Y') }}
                            </p>
                            <p class="text-gray-700 dark:text-gray-300 mb-3">{{ Str::limit($news->body, 100) }}</p>
                            <a href="{{ route('public.news.show', $news->id) }}" class="text-blue-600 font-semibold">Read more →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500">No verified news available yet.</p>
        @endif
    </section>

    <footer class="text-center py-6 text-gray-500 text-sm border-t border-gray-200 dark:border-gray-700">
        © {{ date('Y') }} CheckFakta. All rights reserved.
    </footer>

</body>
</html>
