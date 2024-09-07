<?php

namespace App\Services;

use App\Models\User;
use App\Models\Pricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\PricingRepository;

class PricingService
{

public function __construct(PricingRepository $pricingRepository,){
    $this->pricingRepository = $pricingRepository;
}

public function all(){
    try{
        DB::beginTransaction();
        $user = auth()->user();
        $user_id=$user->id;
        $pricing=$this->pricingRepository->getAll()->where('gym_id',$user_id);
        return $pricing;
        DB::commit();
    }
    catch(Exception $e){
        DB::rollBack();
        throw new Exception(Message::Failed);
    }

}

public function add(Pricing $pricing,Request $request){
    try{
        DB::beginTransaction();
        $user = auth()->user();
        $gym=User::FindOrFail($user->id);
        $gymName = (string) $gym->name;

        $pricing->name=$request->name;
        $pricing->costs=$request->costs;
        $pricing->duration=$request->duration;
        $pricing->costs_type=$request->duration_type;
        // $pricing->start_date=$request->start_date;
        // $pricing->end_date=$request->end_date;
        $pricing->gym_id=$user->id;

        $pricing->save();
        
        
        DB::commit();
        return $pricing;
    }
    catch(Exception $e){
        DB::rollBack();
        // Log the error message
        \Log::info('Error during package save: ' . $e->getMessage());
        // Display a generic error message to the user
        return redirect()->back()->with('error', 'An error occurred while saving the package and pricing information.');
    }

}

public function update(Pricing $pricing,$id,Request $request){
    try{
        DB::beginTransaction();
        $user = auth()->user();
        $gym=User::FindOrFail($user->id);
        $gymName = (string) $gym->name;

        $pricing->name=$request->name;
        $pricing->costs=$request->costs;
        $pricing->costs_type=$request->costs_type;
        $pricing->start_date=$request->start_date;
        $pricing->end_date=$request->end_date;
        // $pricing->gym_id=$user->id;
        
        $pricing->update();
        DB::commit();
        
        return $pricing;
       

    }
    catch(Exception $e){
        DB::rollBack();
        // dd("Here");
        // Log the error message
        \Log::info('Error during package update: ' . $e->getMessage());
        // Display a generic error message to the user
        return redirect()->back()->with('error', 'An error occurred while saving the package and pricing information.');
    }

}


public function delete($id){
    try{
        DB::beginTransaction();         
        $pricing=$this->pricingRepository->getById($id);       
        $pricing->delete();
        DB::commit();
        return $pricing;

    }
    catch(Exception $e){
        DB::rollBack();
    }
}

}    