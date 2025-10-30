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
        </div>

        {{-- 🧠 New Semantic Similarity Section --}}
        @if(!empty($similarities))
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
                            </p>

                            {{-- ✅ Add this section --}}
                            @php
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
</x-app-layout>
