<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBudgetRequest;
use App\Http\Requests\UpdateBudgetRequest;
use App\Models\Budget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $budgets = Budget::where('user_id', auth()->id())->orderByDesc('is_active')->get();
        $activeBudget = $budgets->firstWhere('is_active', auth()->id());

        return Inertia::render(
            'Budget', [
                'title' => 'Budget',
                'budgets' => $budgets,
                'activeBudget' => $activeBudget,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBudgetRequest $request): RedirectResponse
    {

        $validatedReq = $request->validated();

        Budget::create($validatedReq);

        return Redirect::route('budget.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Budget $budget)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBudgetRequest $request, $id)
    {

        $budget = Budget::findOrFail($id);

        $this->authorize('update', $budget);

        if ($budget->is_active) {
            Redirect::back()->with(
                'error', 'This budget is already active.',
            );
        }

        $budget->activate();

        return Redirect::route('budget.index')->with('success', 'Budget activated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $budget = Budget::find($id);

        if (! $budget || $budget->is_active) {
            return Redirect::back()->with('error', "This budget can't be deleted!");
        }
        $budget->delete();

        return Redirect::route('budget.index')->with('success', 'Budget deleted!');
    }
}
