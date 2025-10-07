<x-app-layout>
    <div class="container">
        <h2>My Detection History</h2>

        @if($histories->isEmpty())
            <p>No history yet.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>News Text</th>
                        <th>Result</th>
                        <th>Detected At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $history)
                        <tr>
                            <td>{{ $history->history_id }}</td>
                            <td>{{ $history->news_text }}</td>
                            <td>{{ $history->result }}</td>
                            <td>{{ $history->detected_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
