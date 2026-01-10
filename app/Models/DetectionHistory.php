<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetectionHistory extends Model
{
    use HasFactory;

    /**
     * DATABASE CONFIGURATION
     * Explicitly defining table and primary key for clarity.
     */
    protected $table = 'detection_history';
    protected $primaryKey = 'history_id';

    /**
     * MASS ASSIGNMENT PROTECTION
     * $fillable ensures only these specific columns can be updated via requests.
     * Prevents security vulnerabilities where users might try to inject data.
     */
    protected $fillable = [
        'user_id',
        'user_history_id',
        'news_text',
        'result',
        'svm_confidence',
        'detected_at',
    ];
    
    /**
     * RELATIONSHIP: Many-to-One
     * Each detection record belongs to a specific user.
     * Allows for $history->user to easily retrieve user details.
     */
    public function user()
    {   
        return $this->belongsTo(User::class, 'user_id');
    }

    //booted() method to handle model events because instead of letting the db handle ID, it calsulates the user_history_id manually
    protected static function booted()
{
    static::creating(function ($history) {
        /**
             * LOGIC: Per-User History Sequencing
             * Instead of relying only on the global 'history_id', this calculates
             * a relative count (1, 2, 3...) unique to each specific user.
             * This provides a better user experience for their history dashboard.
             */
        if (!$history->user_history_id) {
            $history->user_history_id = DetectionHistory::where('user_id', $history->user_id)->max('user_history_id') + 1;
        }
    });
}
}
