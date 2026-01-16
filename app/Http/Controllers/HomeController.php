<?php

namespace App\Http\Controllers;

use App\Models\Videos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {

        $data = Cache::remember('kinopoisk_films_rating_page_1', now()->addHours(6), function () {
            return Http::withHeaders([
                'accept' => 'application/json',
                'X-API-KEY' => env('KINOPOISK_API_KEY'),
            ])->get(
                'https://kinopoiskapiunofficial.tech/api/v2.2/films',
                [
                    'order' => 'RATING',
                    'type' => 'ALL',
                    'ratingFrom' => 0,
                    'ratingTo' => 10,
                    'yearFrom' => 1000,
                    'yearTo' => 3000,
                    'page' => 1,
                ]
            )->json();
        });

        $films = $data['items'] ?? [];

        return view('home', compact('films'));

    }
}
