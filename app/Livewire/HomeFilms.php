<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Film;
use Livewire\Component;

class HomeFilms extends Component
{
    public $selectedCategoryId = null;

    public function selectCategory($categoryId)
    {
        $this->selectedCategoryId = $categoryId;
    }

    public function render()
    {
        $categories = Category::all();

        $filmsQuery = Film::query();

        if ($this->selectedCategoryId) {
            $filmsQuery->where('category_id', $this->selectedCategoryId);
        }

        $films = $filmsQuery->latest()->take(12)->get();

        return view('livewire.home-films', compact('categories', 'films'));
    }
}
