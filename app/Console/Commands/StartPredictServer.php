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
    // public function handle()
    // {
    //     $this->info('Starting Python FastAPI predict server...');

    //     // Adjust the path to python and predict_server.py
    //     $python = 'python'; 
    //     $script = base_path('ml/predict_server.py');

    //     // Start server in the background
    //     $command = "$python $script";

    //     /**
    //      * ASYNCHRONOUS EXECUTION
    //      * Logic: We use popen() with pclose() to trigger the command without 
    //      * making PHP wait for the process to finish.
    //      * * Why: If we used exec(), the terminal would hang indefinitely because 
    //      * the FastAPI server is a persistent process. This allows the Artisan 
    //      * command to exit while the Python server remains active.
    //      */
    //     pclose(popen("start /B $command", "r"));

    //     $this->info('Predict server started.');
    // }

    //ni port 8001
    public function handle()
    {
        $this->info('Starting Python FastAPI predict server on port 8001...');

        // 1. We must use uvicorn to serve FastAPI
        // Format: uvicorn folder.filename:app_variable
        $host = '127.0.0.1';
        $port = '8001';
        $appPath = 'ml.predict_server:app';

        // 2. Construct the command
        // We use --no-reload here for the artisan command to keep it stable
        $command = "uvicorn $appPath --host $host --port $port";

        /**
         * ASYNCHRONOUS EXECUTION
         * We use 'start /B' to run it in the background on Windows.
         */
        pclose(popen("start /B $command", "r"));

        $this->info("Predict server is now running at http://$host:$port");
        $this->info("Make sure your NewsController is pointing to this port!");
    }
}
