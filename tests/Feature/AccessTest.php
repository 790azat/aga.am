<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_home_to_login(): void
    {
        $this->get('/home')->assertRedirect('/login');
    }

    public function test_regular_user_sees_home_page(): void
    {
        $this->actingAs(User::factory()->create())->get('/home')->assertOk();
    }

    public function test_staff_is_redirected_from_home_to_admin_dashboard(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get('/home')
            ->assertRedirect(route('admin.dashboard'));

        $this->actingAs(User::factory()->moderator()->create())
            ->get('/home')
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_regular_user_cannot_open_admin_panel(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_moderator_can_open_admin_panel_but_not_moderator_management(): void
    {
        $moderator = User::factory()->moderator()->create();

        $this->actingAs($moderator)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($moderator)->get(route('admin.films'))->assertOk();
        $this->actingAs($moderator)->get(route('admin.moderators'))->assertForbidden();
    }

    public function test_admin_can_open_every_admin_page(): void
    {
        $admin = User::factory()->admin()->create();

        foreach (['dashboard', 'moderators', 'films', 'categories', 'users', 'cashier', 'history', 'settings'] as $page) {
            $this->actingAs($admin)->get(route('admin.'.$page))->assertOk();
        }
    }

    public function test_remove_moderator_cannot_delete_an_admin(): void
    {
        $admin = User::factory()->admin()->create();
        $otherAdmin = User::factory()->admin()->create();
        $moderator = User::factory()->moderator()->create();

        $this->actingAs($admin)
            ->post(route('admin.users.removeModerator'), ['id' => $otherAdmin->id])
            ->assertNotFound();

        $this->actingAs($admin)
            ->post(route('admin.users.removeModerator'), ['id' => $moderator->id])
            ->assertRedirect();

        $this->assertModelExists($otherAdmin);
        $this->assertModelMissing($moderator);
    }

    public function test_user_can_log_in(): void
    {
        $user = User::factory()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/home');

        $this->assertAuthenticatedAs($user);
    }
}
