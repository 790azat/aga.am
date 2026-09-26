<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_is_available_for_guests(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_reset_route_no_longer_exists(): void
    {
        $this->get('/reset')->assertNotFound();
    }
}
