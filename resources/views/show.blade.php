<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-2xl font-bold mb-4">{{ $news->title }}</h1>
        <p class="text-gray-500 mb-6">{{ $news->created_at->format('M d, Y') }}</p>
        @if($news->image)
            <img src="{{ asset('storage/'.$news->image) }}" alt="" class="mb-6 w-full rounded">
        @endif
        <div class="prose max-w-none">{!! nl2br(e($news->body)) !!}</div>
    </div>
</x-app-layout>
