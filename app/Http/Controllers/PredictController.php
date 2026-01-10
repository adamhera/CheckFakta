<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PredictController extends Controller
{   
    /**
     * Handles the prediction request by communicating with the ML service.
     * * CHALLENGE & EVOLUTION:
     * Initially, I used shell_exec (commented below) to run the Python script directly. 
     * However, loading the model on every request took ~60s. I refactored this 
     * to a microservice architecture using FastAPI to keep the model in memory.
     */
    public function predict(Request $request)
    {
        /* // DEPRECATED METHOD: Synchronous script execution
        // Issues: High latency, security risks with shell commands, and blocking PHP process.
        $inputText = $request->input('text');
        // Path to  Python executable
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
        */

        // MODERN METHOD: REST API Consumption via cURL
        $inputText = $request->input('text');
    
    // Initialize cURL to communicate with the FastAPI server (Port 8000)
    $ch = curl_init();

    // Configuration for a POST request with JSON payload
    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/predict");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['text' => $inputText]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    // Execute the request and close connection
    $response = curl_exec($ch);
    curl_close($ch);
    // Parse JSON response from Python service and return to frontend
    $result = json_decode($response, true);
    return response()->json($result);
    }
}
