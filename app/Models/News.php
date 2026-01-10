<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;

    protected $table = 'news'; // if different, adjust
    protected $fillable = ['title', 'image', 'body', 'status']; // allow mass assignment

    // use casts to ensure whenever i pull created_at and updated_at from db,
    // it auto converts to datetime objects so it is easier to format in the frontend
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
