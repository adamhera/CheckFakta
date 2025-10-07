<x-app-layout>
    <div class="py-6 max-w-4xl mx-auto">
        <h2 class="text-2xl font-semibold mb-4">Enter News Text</h2>

        <form action="{{ route('news.store') }}" method="POST">
            @csrf
            <textarea name="news_text" rows="5" class="w-full border rounded p-2" placeholder="Enter news..."></textarea>

            <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                Submit
            </button>
        </form>
    </div>
</x-app-layout>
