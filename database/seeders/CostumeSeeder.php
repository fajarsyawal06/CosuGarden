<?php

// database/seeders/CostumeSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Costume;
use Illuminate\Support\Str;

class CostumeSeeder extends Seeder
{
    public function run(): void
    {
        $anime = Category::where('slug', 'anime')->first();

        if ($anime) {
            Costume::updateOrCreate(
                ['slug' => 'kimetsu-uniform-' . Str::lower(Str::random(4))],
                [
                    'category_id' => $anime->id,
                    'name' => 'Kimetsu Uniform Set',
                    'description' => 'Set lengkap, bahan nyaman untuk event.',
                    'stock' => 10,
                    'price' => 350000,
                    'image_path' => null,
                ]
            );
        }
    }
}
