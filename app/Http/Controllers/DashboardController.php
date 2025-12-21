<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $data = User::with(['expenses.category', 'expenses.budget', 'budgets', 'activeBudget'])
            ->withSum(['expenses as expenses_yearly' => function ($query) {
                $query->yearlyExpenses()->whereHas('budget', function ($q) {
                    $q->where('is_active', true);
                });
            }], 'amount')
            ->withSum(['expenses as expenses_monthly' => function ($query) {
                $query->monthlyExpenses()->whereHas('budget', function ($q) {
                    $q->where('is_active', true);
                });
            }], 'amount')

            ->find(auth()->id());

        $activeBudgetAmount = $data->activeBudget?->amount_limit ?? 0;
        $totalMonthlyExpenses = $data->expenses_monthly ?? 0;
        $remainingAmount = $activeBudgetAmount - $totalMonthlyExpenses;

        return Inertia::render(
            'Dashboard',
            [
                'title' => 'Dashboard',
                'data' => $data,
                'remainingAmount' => $remainingAmount,

            ]
        );
    }
}
