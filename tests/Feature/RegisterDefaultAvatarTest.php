<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterDefaultAvatarTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_assigns_default_avatar_view()
    {
        $res = $this->post('/register', [
            'first_name' => 'Rian',
            'last_name' => 'Test',
            'email' => 'rian@example.com',
            'username' => 'riantest',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'client', // avoid proof_image requirement
            'terms' => '1',
        ]);

        $res->assertRedirect('/login');

        $user = \App\Models\User::where('email', 'rian@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNull($user->avatar);
        $this->assertStringEndsWith('/images/icon/profil.png', $user->avatar_url);
    }
}
