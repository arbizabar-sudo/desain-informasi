<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class ProfileRolesTest extends TestCase
{
    use RefreshDatabase;

    /** @dataProvider rolesProvider */
    public function test_profile_page_accessible_by_role($role)
    {
        $user = User::factory()->create(['role' => $role, 'username' => $role . '_user']);

        // visit by username
        $res = $this->get(route('profile.show', $user->username));
        $res->assertStatus(200);
        // profile page displays the user's name
        $res->assertSee($user->name);

        // visit by id
        $res2 = $this->get(route('profile.show', $user->id));
        $res2->assertStatus(200);
        $res2->assertSee($user->name);

        // visiting a non-existent numeric id should show our friendly 404 with a link to the authenticated user's profile
        $res3 = $this->actingAs($user)->get('/users/999999999');
        $res3->assertStatus(404);
        $res3->assertSee('Profil tidak ditemukan');
        $res3->assertSee(route('profile.show', $user->username ?: $user->id));
    }

    public static function rolesProvider()
    {
        return [
            ['mahasiswa'],
            ['dosen'],
            ['client'],
        ];
    }
}
