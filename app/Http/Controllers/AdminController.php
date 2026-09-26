<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Film;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function films()
    {
        // Получаем все фильмы и категории
        $films = Film::with(['actors', 'category'])->latest()->get();
        $categories = Category::all();
        $allCategories = $categories->pluck('name', 'id'); // [id => name]

        return view('admin.films', ['films' => $films, 'categories' => $categories, 'allCategories' => $allCategories]);
    }

    public function users()
    {
        $users = User::all();

        return view('admin.users', compact('users'));
    }

    public function cashier()
    {
        return view('admin.cashier');
    }

    public function history()
    {
        return view('admin.history');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function moderators()
    {
        $users = User::where('type', 'moderator')->get();

        return view('admin.moderators', compact('users'));
    }

    // Страница категорий
    public function categories()
    {
        $categories = Category::all();

        return view('admin.categories', compact('categories'));
    }

    // Создать категорию
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category created successfully');
    }

    // Обновить категорию
    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully');
    }

    // Удалить категорию
    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $filmsCount = $category->films()->count();

        if ($filmsCount > 0) {
            return back()->with('error', "Нельзя удалить категорию: {$filmsCount} фильмов привязано.");
        }

        $category->delete();

        return back()->with('success', 'Категория успешно удалена');
    }
}
