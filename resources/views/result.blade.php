<x-app-layout>
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
            </p>

            <p>
                <strong>Detected At:</strong><br>
                <span class="text-gray-600">{{ $history->detected_at }}</span>
            </p>
        </div>

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
</x-app-layout>
