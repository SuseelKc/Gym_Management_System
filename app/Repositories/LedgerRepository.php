<?php
namespace App\Repositories;

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
}