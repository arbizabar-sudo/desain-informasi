<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Graphic Design', 'slug' => 'graphic'],
            ['name' => 'Illustration', 'slug' => 'illustration'],
            ['name' => 'Photography', 'slug' => 'photography'],
            ['name' => 'Typography', 'slug' => 'typography'],
            ['name' => 'UI/UX', 'slug' => 'uiux'],
            ['name' => 'Visual Identity', 'slug' => 'identity'],
            ['name' => 'Semua', 'slug' => 'semua'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], ['name' => $category['name']]);
        }
    }
}
