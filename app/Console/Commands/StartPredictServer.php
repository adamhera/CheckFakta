<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartPredictServer extends Command
{
    protected $signature = 'predict:serve';
    protected $description = 'Start the FastAPI predict server';

    public function handle()
    {
        $this->info('Starting Python FastAPI predict server...');

        // Adjust the path to your python and predict_server.py
        $python = 'python'; // or full path, e.g., C:\\Python310\\python.exe
        $script = base_path('ml/predict_server.py');

        // Start server in the background
        $command = "$python $script";

        // Use popen to run it asynchronously
        pclose(popen("start /B $command", "r"));

        $this->info('Predict server started.');
    }
}
