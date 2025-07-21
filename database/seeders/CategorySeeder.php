<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technical issues',
                'slug' => 'TI',
            ],
            [
                'name' => 'Payment issues',
                'slug' => 'PI',
            ],
            [
                'name' => 'Other',
                'slug' => 'AT',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate($category);
        }
    }
}
