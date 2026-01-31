<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetectionHistory;
use Illuminate\Support\Facades\Auth;
// --- ADD THESE TWO LINES ---
use Illuminate\Support\Facades\Http; 
use Illuminate\Http\Client\ConnectionException;
//use Symfony\Component\Process\Process;
//use Symfony\Component\Process\Exception\ProcessFailedException;

class NewsController extends Controller
{
    // Show form
    public function create()
    {
        return view('news_input');
    }

    // Store news text in DB
    // Store news text in DB
// public function store(Request $request)
// {
//     $request->validate([
//         'news_text' => 'required|string',
//     ]);

//     $newsText = $request->news_text;

//     // -----------------------------
//     // Absolute path to Python
//     // -----------------------------
//     $python = 'C:/Users/adamh/AppData/Local/Programs/Python/Python313/python.exe';
//     $script = base_path('ml/predict.py');

//     // -----------------------------
//     // Build and execute command
//     // -----------------------------
//     $command = "\"$python\" \"$script\" " . escapeshellarg($newsText) . " 2>&1";
//     $output = shell_exec($command);

//     // -----------------------------
//     // Clean output
//     // -----------------------------
//    // $result = trim($output); // Expecting "Fake", "Real", "Precaution", or "Unclear"

//    // Try decoding JSON output from Python (new version)
//     $json = json_decode(utf8_encode($output), true);

//     // If valid JSON, extract svm_result & similarities
//     if (isset($json['svm_result'])) {
//         $result = $json['svm_result'];
//         $similarities = $json['semantic_similarity'] ?? [];
//         $svm_confidence = $json['svm_confidence'] ?? null;
//     } else {
//         // Fallback for older text-only output
//         $result = trim($output);
//         $similarities = [];
//         $svm_confidence = null;
//     }
//     // -----------------------------
//     // Save to database
//     // -----------------------------
//     $history = new DetectionHistory();
//     $history->user_id = Auth::id();
//     $history->news_text = $newsText;
//     $history->result = $result;
//     $history->svm_confidence = $svm_confidence;
//     $history->detected_at = now();
//     $history->save();

//     // Redirect to result page
//    // return redirect()->route('news.show', $history->history_id);
//    return view('result', [
//     'history' => $history,
//     'similarities' => $similarities ?? []
// ]);

// }

//page 500
public function store(Request $request)
{
    $request->validate(['news_text' => 'required|string']);
    $newsText = $request->news_text;

    // 1. Give PHP a generous limit so it doesn't crash before we catch the error
    set_time_limit(120);

    $history = new DetectionHistory();
    $history->user_id = Auth::id();
    $history->news_text = $newsText;
    $history->result = 'Pending/Timeout';
    $history->detected_at = now();
    $history->save();

    try {
        // 2. Use the HTTP client instead of shell_exec
        // shell_exec crashes with a red screen; this approach allows a custom view.
        //dulu port dia 8000 instead of 8001
        $response = \Illuminate\Support\Facades\Http::timeout(60)->post('http://127.0.0.1:8001/predict', [
            'text' => $newsText,
        ]);

        if ($response->successful()) {
            $json = $response->json();
            $history->update([
                'result' => $json['svm_result'] ?? 'Unknown',
                'svm_confidence' => $json['svm_confidence'] ?? null,
            ]);

            return view('result', [
                'history' => $history,
                'similarities' => $json['semantic_similarity'] ?? []
            ]);
        }
    } catch (\Exception $e) {
        // 3. FORCE YOUR ORANGE 500 PAGE HERE
        // This stops the red screen from ever appearing.
        return response()->view('errors.500', [], 500);
    }

    return response()->view('errors.500', [], 500);
}





    // Show result
    public function show($id)
    {
        $history = DetectionHistory::findOrFail($id);
        return view('result', compact('history'));
    }

    // Show detection history for logged-in user
    public function history()
    {
        $histories = DetectionHistory::where('user_id', Auth::id())->get();
        return view('history', compact('histories'));
    }
}
