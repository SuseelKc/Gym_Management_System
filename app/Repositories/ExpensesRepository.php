<?php
namespace App\Repositories;

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
}