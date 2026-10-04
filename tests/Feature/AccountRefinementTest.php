<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AccountRefinementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['auth.guards.api.driver' => 'session']);
    }

    public function test_password_change_checks_the_current_password(): void
    {
        $user = User::factory()->create(['password' => Hash::make('current-password'), 'role' => 'user']);
        $this->actingAs($user, 'api')->patchJson('/api/user/account/changepass', [
            'old_password' => 'incorrect-password', 'new_password' => 'replacement-password',
        ])->assertStatus(400);
        $this->assertTrue(Hash::check('current-password', $user->fresh()->password));

        $this->patchJson('/api/user/account/changepass', [
            'old_password' => 'current-password', 'new_password' => 'replacement-password',
        ])->assertOk();
        $this->assertTrue(Hash::check('replacement-password', $user->fresh()->password));
    }

    public function test_password_change_requires_a_valid_new_password(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user, 'api')->patchJson('/api/user/account/changepass', [
            'old_password' => 'password', 'new_password' => 'short',
        ])->assertUnprocessable();
        $this->get('/orderUser')->assertOk();
        $this->get('/changePass')->assertOk();
    }

    public function test_admin_pages_require_a_server_verified_login(): void
    {
        foreach (['/admin', '/admin/order', '/admin/register'] as $url) {
            $this->get($url)->assertRedirect('/admin/login');
        }
        $this->postJson('/admin/session')->assertForbidden();
    }

    public function test_public_registration_cannot_create_an_administrator(): void
    {
        DB::table('opt_regist_forget_account')->insert(['email' => 'customer@example.test', 'OTP' => 123456,
            'type' => 'register', 'created_at' => now(), 'expired_at' => now()->addMinutes(5)]);
        $this->postJson('/api/auth/user/register', ['email' => 'customer@example.test', 'name' => 'Customer',
            'password' => 'customer-password', 'OTP' => '123456', 'role' => 'admin'])->assertOk();
        $this->assertDatabaseHas('users', ['email' => 'customer@example.test', 'role' => 'user']);
        $this->postJson('/api/auth/admin/register', [])->assertUnauthorized();
    }

    public function test_log_mail_recovery_works_without_a_queue_worker(): void
    {
        config(['queue.default' => 'sync', 'mail.default' => 'log', 'mail.mailers.log.channel' => 'mail-test',
            'logging.default' => 'mail-test', 'logging.channels.mail-test' => ['driver' => 'single', 'path' => sys_get_temp_dir().'/petcare-mail-readiness.log']]);
        $user = User::factory()->create(['role' => 'user', 'status' => 'active']);
        $this->postJson('/api/auth/user/account/forgetpass/request/sendOTP', ['email' => $user->email])
            ->assertOk()->assertJsonPath('status', 'success');
        $otp = DB::table('opt_regist_forget_account')->where('email', $user->email)->first();
        $this->assertNotNull($otp);
        $this->assertSame('forget', $otp->type);
        $this->postJson('/api/auth/user/account/forgetpass/request/resetPass', [
            'email' => $user->email, 'OTP' => (string) $otp->OTP, 'password' => 'new-demo-password',
        ])->assertOk()->assertJsonPath('status', 'success');
        $this->assertTrue(Hash::check('new-demo-password', $user->fresh()->password));
        $this->assertDatabaseMissing('opt_regist_forget_account', ['email' => $user->email]);
    }

    public function test_recovery_rejects_expired_codes_and_short_passwords(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        DB::table('opt_regist_forget_account')->insert(['email' => $user->email, 'OTP' => 123456,
            'type' => 'forget', 'created_at' => now()->subMinutes(15), 'expired_at' => now()->subMinutes(5)]);
        $payload = ['email' => $user->email, 'OTP' => '123456', 'password' => 'new-demo-password'];
        $this->postJson('/api/auth/user/account/forgetpass/request/resetPass', $payload)
            ->assertOk()->assertJsonPath('status', 'error');
        $this->postJson('/api/auth/user/account/forgetpass/request/resetPass', [...$payload, 'password' => 'short'])
            ->assertUnprocessable();
    }
}
