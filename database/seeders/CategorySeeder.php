<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Food & Dining'],
            ['name' => 'Transportation'],
            ['name' => 'Utilities'],
            ['name' => 'Housing'],
            ['name' => 'Health'],
            ['name' => 'Entertainment'],
            ['name' => 'Shopping'],
            ['name' => 'Travel'],
            ['name' => 'Education'],
            ['name' => 'Loan'],
            ['name' => 'Others'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
