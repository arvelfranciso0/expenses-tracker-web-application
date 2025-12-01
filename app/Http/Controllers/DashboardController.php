<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // $budgets = Budget::all();
        return Inertia::render(
            'Dashboard',
            [
                'title' => 'Dashboard',
            ]
        );
    }


}
