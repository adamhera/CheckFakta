<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartPredictServer extends Command
{
    /**
     * This allows the server to be started via 'php artisan predict:serve'.
     * It automates the environment setup for the developer.
     */
    protected $signature = 'predict:serve';
    protected $description = 'Start the FastAPI predict server';

    /**
     * EXECUTION LOGIC
     * Handles the asynchronous startup of the Python ML Microservice.
     */
    public function handle()
    {
        $this->info('Starting Python FastAPI predict server...');

        // Adjust the path to python and predict_server.py
        $python = 'python'; 
        $script = base_path('ml/predict_server.py');

        // Start server in the background
        $command = "$python $script";

        /**
         * ASYNCHRONOUS EXECUTION
         * Logic: We use popen() with pclose() to trigger the command without 
         * making PHP wait for the process to finish.
         * * Why: If we used exec(), the terminal would hang indefinitely because 
         * the FastAPI server is a persistent process. This allows the Artisan 
         * command to exit while the Python server remains active.
         */
        pclose(popen("start /B $command", "r"));

        $this->info('Predict server started.');
    }
}
