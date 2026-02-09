<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Web Development',
            'Mobile Development',
            'Data Science',
            'Machine Learning',
            'DevOps',
            'UI/UX Design',
            'Cybersecurity',
            'Cloud Computing',
            'Blockchain',
            'Game Development',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => "Courses related to {$name}.",
                    'is_active' => true,
                ]
            );
        }
    }
}
