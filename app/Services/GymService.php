<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Member;
use App\Models\Expenses;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Mime\Message;
use Illuminate\Support\Facades\File;
use App\Repositories\ExpensesRepository;


class GymService
{
    public function __construct(ExpensesRepository $expensesRepository)
    {       
      $this->expensesRepository = $expensesRepository;
    }

    // public function all(){
    //     try{
    //         DB::beginTransaction();
    //         $user=auth()->user();
    //         $user_id=$user->id;
    //         return $this->expensesRepository->getAll()->where('gym_id',$user_id);
    //         DB::commit();
    //     }
    //     catch(Exception $e){
    //         DB::rollBack();
    //         throw new Exception(Message::Failed);
    //     }
        

    // }

    // public function add(Expenses $expenses,Request $request){
    //     try{
    //         DB::begintransaction();
    //         $user=auth()->user();
    //         $gym=User::FindorFail($user->id);
    //         $expenses->name=$request->name;
    //         $expenses->type=$request->type;
    //         $expenses->costs=$request->costs;
    //         $expenses->start_date=$request->start_date;
    //         $expenses->end_date=$request->end_date;
    //         $expenses->gym_id=$user->id;


    //         $expenses->save();

    //         DB::commit();
    //         return $expenses;

    //     }
    //    catch(Exception $e){
    //     DB::rollBack();
    //     throw new Exception(Message::Failed);
    //     }
    // }

    // public function update(Expenses $expenses,$id,Request $request){
    //     try{
    //         DB::begintransaction();
    //         $user=auth()->user();
    //         $gym=User::FindorFail($user->id);
    //         $expenses->name=$request->name;
    //         $expenses->type=$request->type;
    //         $expenses->costs=$request->costs;
    //         $expenses->start_date=$request->start_date;
    //         $expenses->end_date=$request->end_date;
    //         $expenses->gym_id=$user->id;


    //         $expenses->update();

    //         DB::commit();
    //         return $expenses;
    //     }
    //     catch(Exception $e){
    //         DB::rollBack();
    //         throw new Exception(Message::Failed);
    //         }
    // }

    // public function delete($id){
    //     try{
    //         DB::beginTransaction();
    //         $expenses=$this->expensesRepository->getById($id);
    //         $expenses->delete();
    //         DB::commit();
    //         return $expenses;

    //     }
    //     catch(Exception $e){

    //     }
        
    // }
   
  

    
}
