<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $data = User::with('expenses.category')
            ->withSum(['expenses as expenses_yearly' => function ($query) {
                $query->yearlyExpenses();
            }], 'amount')
            ->withSum(['expenses as expenses_monthly' => function ($query) {
                $query->monthlyExpenses();
            }], 'amount')
            ->find(auth()->id());

        return Inertia::render(
            'Dashboard',
            [
                'title' => 'Dashboard',
                'data' => $data,
            ]
        );
    }
}
