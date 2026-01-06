<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PosterController extends Controller
{
    public function index() {

        $posters = [
            ['img' => 'a1'],
            ['img' => 'a2'],
            ['img' => 'a3'],
            ['img' => 'a4'],
            ['img' => 'a5'],
            ['img' => 'a6'],
            ['img' => 'a7'],
            ['img' => 'a8'],
            ['img' => 'a9']];

        $posters = json_decode(json_encode($posters));

        return view('welcome', ['posters' => $posters]);

    }
}
