<?php
namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Ledger;

class LedgerRepository
{
    public function getAll()
    {
        return Ledger::all();
    }
    public function getById($id)
    {
        return Ledger::find($id);
    }
    public function getWhere($query)
    {    
        return Ledger::where($query);
    } 
    public function getMemberLedger(){

        return Ledger::where('gym_id', auth()->id())->get();
    }
    public function getTopTransactions(){
        return Ledger::where('gym_id', auth()->id())->whereNotNull('credit')->take(10)
        ->latest()->get();
    }
   public function getMember($memberId){

        return Ledger::where('gym_id', auth()->id())->where('member_id', $memberId)->get();

    }
   
    public function previousDebitMonths(){
        $programInceptionDate = Carbon::create(1900, 1, 1); // January 1, 1900
        $previousMonthStart = $programInceptionDate->startOfMonth();
        $previousMonthEnd= Carbon::now()->subMonth()->endOfMonth();
        
        return Ledger::where('gym_id',auth()->id())
        ->whereBetween('created_at',[$previousMonthStart,$previousMonthEnd])
        ->whereNotNull('debit')->sum('debit');
    }
   
    public function previousCreditMonths(){
        $programInceptionDate = Carbon::create(1900, 1, 1); // January 1, 1900
        $previousMonthStart = $programInceptionDate->startOfMonth();
        $previousMonthEnd= Carbon::now()->subMonth()->endOfMonth();
        
        return Ledger::where('gym_id',auth()->id())
        ->whereBetween('created_at',[$previousMonthStart,$previousMonthEnd])
        ->whereNotNull('credit')->sum('credit');
    }

    public function latestMonthCreditSum(){

        $latestMonthStart = Carbon::now()->startOfMonth();
        $latestMonthEnd = Carbon::now()->endOfMonth();

        return Ledger::where('gym_id',auth()->id())
        ->whereBetween('created_at',[$latestMonthStart,$latestMonthEnd])
        ->whereNotNull('credit')->sum('credit');

    }


}