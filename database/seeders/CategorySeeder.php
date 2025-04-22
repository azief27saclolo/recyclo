<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Metal',
                'description' => 'Metal waste materials like aluminum, steel, etc.',
                'color' => '#B8C6DB'
            ],
            [
                'name' => 'Plastic',
                'description' => 'Plastic waste materials like PET bottles, HDPE, etc.',
                'color' => '#A3D9CA'
            ],
            [
                'name' => 'Paper',
                'description' => 'Paper waste materials like newspaper, cardboard, etc.',
                'color' => '#F9EBDE'
            ],
            [
                'name' => 'Glass',
                'description' => 'Glass waste materials like bottles, jars, etc.',
                'color' => '#D4F1F9'
            ],
            [
                'name' => 'Electronics',
                'description' => 'Electronic waste materials like old phones, computers, etc.',
                'color' => '#FEE5E0'
            ],
            [
                'name' => 'Wood',
                'description' => 'Wood waste materials like scraps, pallets, etc.',
                'color' => '#E6D7B9'
            ],
            [
                'name' => 'Fabric',
                'description' => 'Fabric waste materials like old clothes, upholstery, etc.',
                'color' => '#F1E3D3'
            ],
            [
                'name' => 'Rubber',
                'description' => 'Rubber waste materials like tires, mats, etc.',
                'color' => '#DBDBDB'
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'color' => $category['color'],
                'is_active' => true
            ]);
        }

        // Update existing posts to link to the new category_id
        $this->migrateExistingPosts();
    }

    /**
     * Update existing posts to use the new category_id field.
     */
    private function migrateExistingPosts(): void
    {
        $posts = Post::all();
        $categories = Category::all()->keyBy('name');

        foreach ($posts as $post) {
            // Check if the post has a category text value and if that category exists in our new table
            if ($post->category && isset($categories[$post->category])) {
                $post->category_id = $categories[$post->category]->id;
                $post->save();
            }
        }
    }
}
