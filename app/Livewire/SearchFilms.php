<?php

namespace App\Livewire;

use App\Models\Film;
use Livewire\Component;

class SearchFilms extends Component
{
    public string $search = '';

    public bool $showDropdown = false;

    public function updatedSearch()
    {
        $this->showDropdown = strlen($this->search) > 0;
    }

    public function selectFilm($title)
    {
        $this->search = $title;
        $this->showDropdown = false;
    }

    public function render()
    {
        $films = [];

        if ($this->showDropdown) {
            $films = Film::query()
                ->where('name', 'like', '%'.$this->search.'%')
                ->limit(10)
                ->get();
        }

        return view('livewire.search-films', compact('films'));
    }
}
