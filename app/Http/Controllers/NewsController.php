<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetectionHistory;
use Illuminate\Support\Facades\Auth;

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
public function store(Request $request)
{
    $request->validate([
        'news_text' => 'required|string',
    ]);

    $newsText = $request->news_text;

    // -----------------------------
    // Absolute path to Python
    // -----------------------------
    $python = 'C:/Users/adamh/AppData/Local/Programs/Python/Python313/python.exe';
    $script = base_path('ml/predict.py');

    // -----------------------------
    // Build and execute command
    // -----------------------------
    $command = "\"$python\" \"$script\" " . escapeshellarg($newsText) . " 2>&1";
    $output = shell_exec($command);

    // -----------------------------
    // Clean output
    // -----------------------------
    $result = trim($output); // Expecting "Fake", "Real", "Precaution", or "Unclear"

    // -----------------------------
    // Save to database
    // -----------------------------
    $history = new DetectionHistory();
    $history->user_id = Auth::id();
    $history->news_text = $newsText;
    $history->result = $result;
    $history->detected_at = now();
    $history->save();

    // Redirect to result page
    return redirect()->route('news.show', $history->history_id);
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
