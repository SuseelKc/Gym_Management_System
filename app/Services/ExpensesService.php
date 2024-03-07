<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Member;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Mime\Message;
use Illuminate\Support\Facades\File;
use App\Repositories\ExpensesRepository;


class ExpensesService
{
    public function __construct(ExpensesRepository $expensesRepository)
    {       
      $this->expensesRepository = $expensesRepository;
    }

    public function all(){
        try{
            DB::beginTransaction();
            $user=auth()->user();
            $user_id=$user->id;
            return $this->expensesRepository->getAll()->where('gym_id',$user_id);
            DB::commit();
        }
        catch(Exception $e){
            DB::rollBack();
            throw new Exception(Message::Failed);
        }

        

    }

   

    

    
}
