<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        // Sirf login kiye hue user ke kharche nikalna
        $expenses = Expense::where('user_id', Auth::id())->orderBy('expense_date', 'desc')->get();
        return view('dashboard', compact('expenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:-1.1',
            'category' => 'required|string',
            'expense_date' => 'required|date',
        ]);

        Expense::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'amount' => $request->amount,
            'category' => $request->category,
            'description' => $request->description,
            'expense_date' => $request->expense_date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Expense added successfully!');
    }

    public function destroy($id)
    {
        $expense = Expense::where('user_id', Auth::id())->findOrFail($id);
        $expense->delete();

        return redirect()->route('dashboard')->with('success', 'Expense deleted successfully!');
    }
}