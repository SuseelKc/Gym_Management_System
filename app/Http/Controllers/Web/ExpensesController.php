<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\User;
use App\Models\Expenses;
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
            return view('admin.expenses.index',compact('expenses'));
        }
        catch(Exception $e){          
        }
    }

    public function create(){
        try{          
            $gym_id=auth()->id();
            $gym=User::FindOrFail($gym_id);
            return view('admin.expenses.create',compact('gym'));
        }
        catch(Exception $e){

        }

    }
    public function store(Request $request){
        try{    
            
            $expenses = new Expenses();
            $expenses = $this->expensesService->add($expenses,$request);
            toast('Expenses Added Successfully!','success');

            return redirect()->intended(route('expenses.index'));

        }
        catch(Exception $e){

        }

    }

}
