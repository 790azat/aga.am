<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    /* ================= FILM PAGE ================= */
    public function index($film_id)
    {
        $film = Film::findOrFail($film_id);

        $relatedFilms = Film::where('category_id', $film->category_id)
            ->where('id', '!=', $film->id)
            ->limit(6)
            ->get();

        $comments = Film::find($film_id)->comments;

        return view('film', compact('film', 'relatedFilms', 'comments'));
    }

    /* ================= CREATE ================= */
    public function upload(Request $request)
    {
        $data = $this->validateData($request);

        $film = new Film($data);

        // category
        $film->category_id = $request->category_id;

        // genres → string
        $film->genres = $request->added_genres;

        // files
        $film->poster = $this->uploadFile($request, 'poster', 'posters');
        $film->background = $this->uploadFile($request, 'background', 'backgrounds');
        $film->logo = $this->uploadFile($request, 'logo', 'logos');
        $film->video = $this->uploadFile($request, 'video', 'videos');

        $film->save();

        $actors = explode(',', $request->actors);

        foreach ($actors as $actorName) {

            $actorName = trim($actorName);

            if ($actorName) {

                $actor = new Actor();
                $actor->name = $actorName;
                $actor->save();

                DB::table('actor_film')->insert([
                    'actor_id' => $actor->id,
                    'film_id'  => $film->id
                ]);
            }
        }

        return back()->with('success', 'Film uploaded successfully!');
    }


    /* ================= UPDATE ================= */
    public function update(Request $request, Film $film)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'added_genres' => 'required|array',
            'poster' => 'nullable|image',
            'background' => 'nullable|image',
            'logo' => 'nullable|image',
            'video' => 'nullable|mimes:mp4,mov,avi',
            'year' => 'nullable|integer',
            'actors' => 'nullable|string',
            'director' => 'nullable|string',
            'producer' => 'nullable|string',
        ]);

        $data['genres'] = $data['added_genres'];
        // Загружаем файлы если есть

        if($request->hasFile('poster')) $data['poster'] = $request->file('poster')->store('posters','public');
        if($request->hasFile('background')) $data['background'] = $request->file('background')->store('backgrounds','public');
        if($request->hasFile('logo')) $data['logo'] = $request->file('logo')->store('logos','public');
        if($request->hasFile('video')) $data['video'] = $request->file('video')->store('videos','public');


        $actors = explode(',', $request->actors);

        foreach ($actors as $actorName) {

            $actorName = trim($actorName);

            if ($actorName) {

                $actor = new Actor();
                $actor->name = $actorName;
                $actor->save();

                DB::table('actor_film')->insert([
                    'actor_id' => $actor->id,
                    'film_id'  => $request['id']
                ]);
            }
        }

        Film::find($request['id'])->update($data);

        return redirect()->back()->with('success','Film updated successfully!');
    }



    /* ================= DELETE ================= */
    public function destroy($id)
    {
        $film = Film::findOrFail($id);

        $this->deleteFile($film->poster);
        $this->deleteFile($film->background);
        $this->deleteFile($film->logo);
        $this->deleteFile($film->video);

        $film->delete();

        return redirect('/admin/films')->with('success', 'Film deleted successfully.');
    }

    /* ================= HELPERS ================= */

    private function validateData(Request $request, $isCreate = true)
    {
        return $request->validate([
            'name'       => 'required|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'year'       => 'nullable|integer',
            'actors'     => 'nullable|string',
            'director'   => 'nullable|string',
            'producer'   => 'nullable|string',
            'genres'     => 'nullable|array',

            'poster'     => 'nullable|image|max:10240',
            'background' => 'nullable|image|max:10240',
            'logo'       => 'nullable|image|max:10240',
            'video'      => 'nullable|mimes:mp4,mov,avi,webm|max:512000',
        ]);
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
