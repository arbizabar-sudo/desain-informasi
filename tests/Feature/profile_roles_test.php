<?php

use App\Models\User;

beforeEach(function () {
    // use RefreshDatabase provided by TestCase bootstrap
});

it('can view profile pages for mahasiswa, dosen, and client', function ($role) {
    $user = User::factory()->create(['role' => $role, 'username' => $role . '_user']);

    // by username
    $this->get(route('profile.show', $user->username))->assertOk()->assertSee($user->name);

    // by id
    $this->get(route('profile.show', $user->id))->assertOk()->assertSee($user->name);
})->with([['mahasiswa'], ['dosen'], ['client']]);

it('resolves usernames that contain spaces or dashes (common cause of 404)', function () {
    $username = 'Mahasiswa User';
    $user = User::factory()->create(['role' => 'mahasiswa', 'username' => $username]);

    // direct username (URL-encoded space)
    $this->get(route('profile.show', $user->username))->assertOk()->assertSee($user->name);

    // dashed variant (e.g. links using slugs)
    $this->get('/users/' . str_replace(' ', '-', $user->username))->assertOk()->assertSee($user->name);

    // lowercase / case-insensitive variant
    $this->get('/users/' . mb_strtolower($user->username))->assertOk()->assertSee($user->name);
});

it('resolves usernames that contain spaces or dashes (common cause of 404)', function () {
    $username = 'Mahasiswa User';
    $user = User::factory()->create(['role' => 'mahasiswa', 'username' => $username]);

    // direct username (URL-encoded space)
    $this->get(route('profile.show', $user->username))->assertOk()->assertSee($user->username);

    // dashed variant (e.g. links using slugs)
    $this->get('/users/' . str_replace(' ', '-', $user->username))->assertOk()->assertSee($user->username);

    // lowercase / case-insensitive variant
    $this->get('/users/' . mb_strtolower($user->username))->assertOk()->assertSee($user->username);
});
