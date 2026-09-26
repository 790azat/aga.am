<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Film;
use Livewire\Attributes\Url;
use Livewire\Component;

class HomeFilms extends Component
{
    #[Url(as: 'category')]
    public $selectedCategoryId = null;

    #[Url]
    public string $tab = 'trending';

    public function selectCategory($categoryId)
    {
        $this->selectedCategoryId = $categoryId;
    }

    public function selectTab(string $tab)
    {
        $this->tab = in_array($tab, ['trending', 'popular', 'recent'], true) ? $tab : 'trending';
    }

    public function render()
    {
        $categories = Category::all();

        $filmsQuery = Film::query();

        if ($this->selectedCategoryId) {
            $filmsQuery->where('category_id', $this->selectedCategoryId);
        }

        match ($this->tab) {
            'popular' => $filmsQuery->withCount('comments')->orderByDesc('comments_count')->orderByDesc('rating'),
            'recent' => $filmsQuery->latest(),
            default => $filmsQuery->orderByDesc('rating')->latest(),
        };

        $films = $filmsQuery->take(18)->get();

        // Фильм для главного баннера: самый высокий рейтинг среди фильмов с фоном
        $featured = Film::with('category')
            ->whereNotNull('background')
            ->orderByDesc('rating')
            ->latest()
            ->first() ?? Film::with('category')->latest()->first();

        return view('livewire.home-films', compact('categories', 'films', 'featured'));
    }
}
