<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Http\Request;
use App\Services\ExpensesService;
use App\Http\Controllers\Controller;

class ExpensesController extends Controller
{
    //
    
    public function __construct(ExpensesService $expensesService)
    {
        $this->expensesService = $expensesService;
       
    }
    
    public function index(){
        try{
            $expenses=$this->expensesService->all();
            // dd("Here");
            return view('admin.expenses.index',compact('expenses'));
        }
        catch(Exception $e){
           
        }

    }


}
