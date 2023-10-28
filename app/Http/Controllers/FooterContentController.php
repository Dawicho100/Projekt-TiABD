<?php

// app/Http/Controllers/FooterContentController.php

namespace App\Http\Controllers;

use App\Models\FooterContent;
use App\Models\Pages;
use Illuminate\Http\Request;

class FooterContentController extends Controller
{
    public function show($slug)
    {
        $page = Pages::where('slug', $slug)->first();
        $pages = Pages::all(); // Pobieramy wszystkie strony
        return view('show', compact('page', 'pages'));
    }


}
