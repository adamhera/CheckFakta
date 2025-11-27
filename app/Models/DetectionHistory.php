<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetectionHistory extends Model
{
    use HasFactory;

    protected $table = 'detection_history';
    protected $primaryKey = 'history_id';

    protected $fillable = [
        'user_id',
        'user_history_id',
        'news_text',
        'result',
        'svm_confidence',
        'detected_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted()
{
    static::creating(function ($history) {
        if (!$history->user_history_id) {
            $history->user_history_id = DetectionHistory::where('user_id', $history->user_id)->max('user_history_id') + 1;
        }
    });
}
}
