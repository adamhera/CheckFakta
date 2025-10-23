<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PredictController extends Controller
{
    public function predict(Request $request)
    {
        $inputText = $request->input('text');

        // Path to your Python executable (adjust if needed)
        $python = 'python';
        $script = base_path('ml/predict.py');

        // Escape the input text safely
        $escapedInput = escapeshellarg($inputText);

        // Execute the Python script and capture the output
        $command = "$python $script $escapedInput";
        $output = shell_exec($command);

        // Decode JSON output
        $result = json_decode($output, true);

        return response()->json($result);
    }
}
