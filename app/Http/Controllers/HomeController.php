<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Film;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Админы и модераторы попадают в админку
        if (in_array(Auth::user()->type, ['admin', 'moderator'], true)) {
            return redirect()->route('admin.dashboard');
        }

        $films = Film::all();
        $categories = Category::all();

        return view('home', compact('films', 'categories'));
    }
}
