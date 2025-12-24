<?php

use Database\Seeders\SampleArtworksSeeder;
use App\Models\Artwork;
use Illuminate\Support\Facades\Storage;

it('runs sample artworks seeder and creates artworks and files', function () {
    // run seeder
    (new SampleArtworksSeeder())->run();

    // assert artworks created
    $this->assertDatabaseHas('artworks', ['title' => 'Sketsa 2']);

    // assert file exists in storage
    expect(Storage::disk('public')->exists('artworks/sample.svg'))->toBeTrue();
});
