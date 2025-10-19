<?php
namespace App\Http\Controllers;

use App\Models\News;

class PublicNewsController extends Controller
{
    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('news.show', compact('news'));
    }
}
