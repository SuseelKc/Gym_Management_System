<?php
namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Expenses;
use App\Repositories\ExpensesRepository;

class ExpensesRepository
{
    public function getAll()
    {
        return Expenses::all();
    }
    public function getById($id)
    {
        return Expenses::find($id);
    }
    public function getWhere($query)
    {
        return Expenses::where($query);
    }
    public function latestMonthExpensesSum(){

        $latestMonthStart = Carbon::now()->startOfMonth();
        $latestMonthEnd = Carbon::now()->endOfMonth();

        return Expenses::where('gym_id',auth()->id())
        ->whereBetween('start_date',[$latestMonthStart,$latestMonthEnd])
        ->sum('costs');
    }
    public function latestYearExpensesSum(){

        $latestYearStart = Carbon::now()->startOfYear();
        $latestYearEnd = Carbon::now()->endOfYear();

        return Expenses::where('gym_id',auth()->id())
        ->whereBetween('start_date',[$latestYearStart,$latestYearEnd])
        ->sum('costs');

    }
    public function expensesUptoPreviousMth(){
        $programInceptionDate = Carbon::create(1900, 1, 1); // January 1, 1900
        $previousMonthStart = $programInceptionDate->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        return Expenses::where('gym_id',auth()->id())
        ->whereBetween('start_date',[$previousMonthStart,$previousMonthEnd])
        ->sum('costs');
    }
}