<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DetectionHistory;

class PopulateUserHistoryId extends Command
{
    protected $signature = 'history:populate-user-id';
    protected $description = 'Populate user_history_id for existing detection_history records';

    public function handle()
    {
        // Get all users
        $users = DetectionHistory::select('user_id')->distinct()->pluck('user_id');

        foreach ($users as $userId) {
            $this->info("Processing user_id: $userId");

            // Get all histories for this user, ordered by history_id
            $histories = DetectionHistory::where('user_id', $userId)
                ->orderBy('history_id')
                ->get();

            $counter = 1;
            foreach ($histories as $history) {
                $history->user_history_id = $counter++;
                $history->save();
            }
        }

        $this->info("All user_history_id values populated successfully.");
    }
}
