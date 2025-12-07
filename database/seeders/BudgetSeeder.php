<?php

namespace Database\Seeders;

use App\Models\Budget;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $budgets = [
            ['user_id' => 1, 'amount_limit' => 10000, 'source' => 'Salary', 'is_active' => 1],
        ];

        foreach ($budgets as $budget) {
            Budget::create($budget);
        }
    }
}
