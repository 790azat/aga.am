<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    /* ================= FILM PAGE ================= */
    public function index($film_id)
    {
        $film = Film::with(['actors', 'category'])->findOrFail($film_id);

        $relatedFilms = Film::where('category_id', $film->category_id)
            ->where('id', '!=', $film->id)
            ->limit(6)
            ->get();

        $comments = $film->comments;

        return view('film', compact('film', 'relatedFilms', 'comments'));
    }

    /* ================= CREATE ================= */
    public function upload(Request $request)
    {
        $data = $this->validateData($request);

        $film = new Film(collect($data)->except(['actors', 'added_genres', 'poster', 'background', 'logo', 'video'])->all());

        // жанры хранятся как массив id категорий
        $film->genres = $data['added_genres'] ?? [];

        // files
        $film->poster = $this->uploadFile($request, 'poster', 'posters');
        $film->background = $this->uploadFile($request, 'background', 'backgrounds');
        $film->logo = $this->uploadFile($request, 'logo', 'logos');
        $film->video = $this->uploadFile($request, 'video', 'videos');

        $film->save();

        $this->syncActors($film, $request->actors);

        return back()->with('success', 'Film uploaded successfully!');
    }

    /* ================= UPDATE ================= */
    public function update(Request $request, Film $film)
    {
        $data = $this->validateData($request);

        $film->fill(collect($data)->except(['actors', 'added_genres', 'poster', 'background', 'logo', 'video'])->all());
        $film->genres = $data['added_genres'] ?? [];

        // Загружаем новые файлы, старые удаляем
        foreach (['poster' => 'posters', 'background' => 'backgrounds', 'logo' => 'logos', 'video' => 'videos'] as $field => $folder) {
            if ($request->hasFile($field)) {
                $this->deleteFile($film->$field);
                $film->$field = $this->uploadFile($request, $field, $folder);
            }
        }

        $film->save();

        $this->syncActors($film, $request->actors);

        return redirect()->back()->with('success', 'Film updated successfully!');
    }

    /* ================= DELETE ================= */
    public function destroy(Film $film)
    {

        $this->deleteFile($film->poster);
        $this->deleteFile($film->background);
        $this->deleteFile($film->logo);
        $this->deleteFile($film->video);

        $film->delete();

        return redirect('/admin/films')->with('success', 'Film deleted successfully.');
    }

    /* ================= HELPERS ================= */

    private function validateData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'year' => 'nullable|integer',
            'actors' => 'nullable|string',
            'director' => 'nullable|string',
            'producer' => 'nullable|string',
            'added_genres' => 'nullable|array',
            'added_genres.*' => 'integer|exists:categories,id',

            'poster' => 'nullable|image|max:10240',
            'background' => 'nullable|image|max:10240',
            'logo' => 'nullable|image|max:10240',
            'video' => 'nullable|mimes:mp4,mov,avi,webm|max:512000',
        ]);
    }

    /**
     * Привязать актёров по именам через запятую.
     * Существующие актёры переиспользуются, дубликаты не создаются.
     */
    private function syncActors(Film $film, ?string $actors): void
    {
        $ids = collect(explode(',', (string) $actors))
            ->map(fn ($name) => trim($name))
            ->filter()
            ->unique()
            ->map(fn ($name) => Actor::firstOrCreate(['name' => $name])->id);

        $film->actors()->sync($ids);
    }

    private function uploadFile(Request $request, $field, $folder)
    {
        return $request->hasFile($field)
            ? $request->file($field)->store($folder, 'public')
            : null;
    }

    private function deleteFile($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
