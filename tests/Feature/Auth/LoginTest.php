<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_with_invalid_credentials_returns_error()
    {
        $response = $this->post('/login', ['username' => 'no', 'password' => 'wrong']);

        $response->assertSessionHasErrors('username');
    }

    public function test_successful_login_redirects_to_dashboard()
    {
        $user = User::factory()->create(['username' => 'op', 'password' => bcrypt('secret123'), 'role' => 'operator', 'status' => 'aktif']);

        $response = $this->post('/login', ['username' => 'op', 'password' => 'secret123']);

        $response->assertRedirect('/dashboard/'.$user->username);
        $this->assertAuthenticatedAs($user);
    }

    public function test_mahasiswa_with_nonactive_status_is_blocked()
    {
        $user = User::factory()->create(['username' => 'mhs', 'password' => bcrypt('secret123'), 'role' => 'mahasiswa', 'status' => 'Non Aktif']);

        $response = $this->post('/login', ['username' => 'mhs', 'password' => 'secret123']);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
}
