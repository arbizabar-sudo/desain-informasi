<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Artwork;
use Illuminate\Support\Facades\Storage;

class SeedSampleArtworks extends Command
{
    protected $signature = 'seed:sample-artworks';
    protected $description = 'Create a sample user and artworks with placeholder images';

    public function handle()
    {
        $user = User::firstOrCreate(
            ['email' => 'sample@local.test'],
            ['name' => 'Sample Creator', 'username' => 'samplecreator', 'password' => bcrypt('password')]
        );

        if (!Storage::disk('public')->exists('artworks')) {
            Storage::disk('public')->makeDirectory('artworks');
        }

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="800" viewBox="0 0 800 800"><rect width="100%" height="100%" fill="#f6f6f6"/><g fill="#ddd"><rect x="40" y="40" width="200" height="200" rx="6"/><rect x="260" y="40" width="200" height="200" rx="6"/><rect x="40" y="260" width="420" height="420" rx="6"/></g><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#999" font-size="28">Artwork Placeholder</text></svg>';

        Storage::disk('public')->put('artworks/sample.svg', $svg);

        Artwork::firstOrCreate([
            'user_id' => $user->id,
            'title' => 'Sketsa 2',
            'description' => 'Deskripsi karya contoh (poster, teknik, dll).',
            'image_path' => 'artworks/sample.svg',
        ]);

        $this->info('Sample artworks created');
        return 0;
    }
}
