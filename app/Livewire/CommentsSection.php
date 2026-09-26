<?php

namespace App\Livewire;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CommentsSection extends Component
{
    public $filmId;

    public $text = '';

    public function mount($filmId)
    {
        $this->filmId = $filmId;
    }

    public function cancel()
    {
        $this->text = '';
    }

    public function send()
    {
        // Комментировать могут только авторизованные пользователи
        if (! Auth::check()) {
            return $this->redirect(route('login'));
        }

        $this->validate([
            'text' => 'required|min:2',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'film_id' => $this->filmId,
            'text' => $this->text,
        ]);

        $this->text = '';
    }

    public function render()
    {
        $comments = Comment::with('user')
            ->where('film_id', $this->filmId)
            ->latest()
            ->get();

        return view('livewire.comments-section', compact('comments'));
    }
}
