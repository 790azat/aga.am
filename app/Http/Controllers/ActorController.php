<?php

namespace App\Http\Controllers;

use App\Models\Actor;

class ActorController extends Controller
{
    public function index($id)
    {

        $actor = Actor::with('films')->findOrFail($id);

        return view('actor', compact('actor'));
    }
}
