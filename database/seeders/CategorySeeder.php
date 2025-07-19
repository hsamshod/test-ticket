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
                'slug' => 'technical_issues',
            ],
            [
                'name' => 'Payment issues',
                'slug' => 'payment_issues',
            ],
            [
                'name' => 'Other',
                'slug' => 'other',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate($category);
        }
    }
}
