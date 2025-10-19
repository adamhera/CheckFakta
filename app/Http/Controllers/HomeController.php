<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        // get latest 3 verified news
        $latestNews = News::where('status', 'verified')
                          ->orderBy('created_at', 'desc')
                          ->take(3)
                          ->get();

        return view('welcome', compact('latestNews'));
    }
}
