<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserPasswordCommandTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        putenv('NEW_PASSWORD');
        parent::tearDown();
    }

    public function test_it_sets_new_password(): void
    {
        $user = User::factory()->create(['email' => 'a@example.com']);
        putenv('NEW_PASSWORD=new-secret-123');

        $this->artisan('user:password', ['email' => 'a@example.com'])->assertExitCode(0);

        $this->assertTrue(Hash::check('new-secret-123', $user->fresh()->password));
    }

    public function test_it_requires_password_and_existing_user(): void
    {
        $this->artisan('user:password', ['email' => 'a@example.com'])->assertExitCode(1);

        putenv('NEW_PASSWORD=new-secret-123');
        $this->artisan('user:password', ['email' => 'none@example.com'])->assertExitCode(1);
    }
}
