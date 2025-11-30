<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PredictController extends Controller
{
    public function predict(Request $request)
    {
        // $inputText = $request->input('text');

        // // Path to your Python executable (adjust if needed)
        // $python = 'python';
        // $script = base_path('ml/predict.py');

        // // Escape the input text safely
        // $escapedInput = escapeshellarg($inputText);

        // // Execute the Python script and capture the output
        // $command = "$python $script $escapedInput";
        // $output = shell_exec($command);

        // // Decode JSON output
        // $result = json_decode($output, true);

        // return response()->json($result);
        $inputText = $request->input('text');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/predict");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['text' => $inputText]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    return response()->json($result);
    }
}
