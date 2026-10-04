<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['auth.guards.api.driver' => 'session']);
    }

    public function test_customer_can_edit_only_their_own_supported_profile_fields(): void
    {
        $customer = User::factory()->create(['role' => 'user']);
        $other = User::factory()->create(['name' => 'Another customer', 'role' => 'user']);

        $this->actingAs($customer, 'api')->getJson('/api/user/account/profile')
            ->assertOk()->assertJsonPath('data.email', $customer->email);
        $this->patchJson('/api/user/account/profile', [
            'name' => 'Updated customer', 'email' => 'updated@example.test',
            'id' => $other->id, 'role' => 'admin',
        ])->assertOk()->assertJsonPath('status', 'success');

        $this->assertSame('Updated customer', $customer->fresh()->name);
        $this->assertSame('updated@example.test', $customer->fresh()->email);
        $this->assertSame('user', $customer->fresh()->role);
        $this->assertSame('Another customer', $other->fresh()->name);

        $this->patchJson('/api/user/account/profile', [
            'name' => 'Updated customer', 'email' => $other->email,
        ])->assertUnprocessable()->assertJsonValidationErrors('email');
    }

    public function test_profile_endpoints_require_authentication(): void
    {
        $this->getJson('/api/user/account/profile')->assertUnauthorized();
        $this->patchJson('/api/user/account/profile', [
            'name' => 'Guest', 'email' => 'guest@example.test',
        ])->assertUnauthorized();
    }
}
