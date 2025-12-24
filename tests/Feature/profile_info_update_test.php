<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows user to update profile info fields', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->put(route('profile.update'), [
            'username' => $user->username,
            'headline' => 'Creative Director',
            'institution' => 'Art Institute',
            'location' => 'Jakarta',
            'website' => 'https://example.com',
        ])
        ->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'headline' => 'Creative Director',
        'institution' => 'Art Institute',
        'location' => 'Jakarta',
        'website' => 'https://example.com',
    ]);
});
