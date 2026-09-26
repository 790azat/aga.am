<?php

namespace App\Http\Controllers;

use App\Models\Film;

class PosterController extends Controller
{
    public function index()
    {

        $posters = Film::take(9)->pluck('poster');

        return view('welcome', compact('posters'));

    }
}
