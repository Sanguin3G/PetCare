<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetCareTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_homepage_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function test_the_application_is_named_petcare(): void
    {
        $this->assertSame('PetCare', config('app.name'));
    }
}
