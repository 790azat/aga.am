<?php

namespace Tests\Feature;

use App\Livewire\CommentsSection;
use App\Models\Actor;
use App\Models\Category;
use App\Models\Film;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FilmTest extends TestCase
{
    use RefreshDatabase;

    public function test_film_page_is_shown(): void
    {
        $film = Film::create(['name' => 'Inception']);

        $this->get('/film/'.$film->id)->assertOk()->assertSee('Inception');
    }

    public function test_missing_film_and_actor_return_404(): void
    {
        $this->get('/film/999')->assertNotFound();
        $this->get('/actor/999')->assertNotFound();
    }

    public function test_admin_can_upload_film_without_duplicate_actors(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::create(['name' => 'Drama']);
        Actor::create(['name' => 'Leonardo DiCaprio']);

        $this->actingAs($admin)->post(route('film.upload'), [
            'name' => 'Inception',
            'category_id' => $category->id,
            'added_genres' => [$category->id],
            'actors' => 'Leonardo DiCaprio, Tom Hardy, Tom Hardy',
        ])->assertRedirect();

        $film = Film::where('name', 'Inception')->firstOrFail();

        $this->assertSame(2, Actor::count());
        $this->assertEqualsCanonicalizing(['Leonardo DiCaprio', 'Tom Hardy'], $film->actors->pluck('name')->all());
        $this->assertSame([$category->id], $film->genres->pluck('id')->all());
    }

    public function test_admin_can_update_film(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::create(['name' => 'Drama']);
        $film = Film::create(['name' => 'Old name']);

        $this->actingAs($admin)->put(route('film.update', $film), [
            'name' => 'New name',
            'category_id' => $category->id,
            'added_genres' => [$category->id],
            'actors' => 'Tom Hardy',
            'year' => 2010,
        ])->assertRedirect();

        $film->refresh();

        $this->assertSame('New name', $film->name);
        $this->assertSame(2010, (int) $film->year);
        $this->assertSame(['Tom Hardy'], $film->actors->pluck('name')->all());

        // повторное сохранение не плодит актёров
        $this->actingAs($admin)->put(route('film.update', $film), [
            'name' => 'New name',
            'category_id' => $category->id,
            'actors' => 'Tom Hardy',
        ])->assertRedirect();

        $this->assertSame(1, Actor::count());
        $this->assertSame(1, $film->actors()->count());
    }

    public function test_admin_can_delete_film(): void
    {
        $admin = User::factory()->admin()->create();
        $film = Film::create(['name' => 'To delete']);

        $this->actingAs($admin)->delete(route('film.destroy', $film))->assertRedirect('/admin/films');

        $this->assertModelMissing($film);
    }

    public function test_regular_user_cannot_manage_films(): void
    {
        $film = Film::create(['name' => 'Protected']);

        $this->actingAs(User::factory()->create())
            ->delete(route('film.destroy', $film))
            ->assertForbidden();
    }

    public function test_guest_cannot_comment(): void
    {
        $film = Film::create(['name' => 'Inception']);

        Livewire::test(CommentsSection::class, ['filmId' => $film->id])
            ->set('text', 'Great film')
            ->call('send')
            ->assertRedirect(route('login'));

        $this->assertSame(0, $film->comments()->count());
    }

    public function test_user_can_comment(): void
    {
        $film = Film::create(['name' => 'Inception']);

        Livewire::actingAs(User::factory()->create())
            ->test(CommentsSection::class, ['filmId' => $film->id])
            ->set('text', 'Great film')
            ->call('send');

        $this->assertSame(1, $film->comments()->count());
    }
}
