@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col">

    <!-- Navbar -->
    <nav class="flex justify-between items-center px-6 py-4 bg-white shadow">
        <h1 class="text-2xl font-bold text-blue-600">CheckFakta</h1>
        <div>
            <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 mx-2">Login</a>
            <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600 mx-2">Register</a>
        </div>
    </nav>

    <!-- Hero section -->
    <div class="flex-grow flex flex-col items-center justify-center text-center">
        <h2 class="text-4xl font-semibold mb-4">Verify the Truth with CheckFakta</h2>
        <a href="{{ route('news.create') }}" 
           class="bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition">
            Check News
        </a>
    </div>

    <!-- Latest Verified News -->
    <section class="px-10 py-10 bg-white">
        <h3 class="text-2xl font-semibold mb-6 text-center">Latest Verified News</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse ($latestNews as $news)
                <div class="bg-gray-100 rounded-lg shadow hover:shadow-lg transition">
                    <img src="{{ asset('images/news-placeholder.jpg') }}" 
                         alt="news image" class="rounded-t-lg w-full h-48 object-cover">
                    <div class="p-4">
                        <h4 class="text-lg font-bold">{{ Str::limit($news->news_text, 50) }}</h4>
                        <p class="text-sm text-gray-500 mb-2">{{ $news->detected_at->format('M d, Y') }}</p>
                        <p class="text-gray-700">{{ Str::limit($news->news_text, 100) }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center col-span-3 text-gray-500">No verified news available yet.</p>
            @endforelse
        </div>
    </section>

</div>
@endsection
