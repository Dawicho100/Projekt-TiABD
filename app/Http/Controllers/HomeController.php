<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pages;

class HomeController extends Controller
{
    public function index()
    {
        $footerContents = Pages::where('slug', 'footer')->get();

        return view('welcome', compact('footerContents'));
    }
}

