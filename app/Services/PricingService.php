<?php

namespace App\Services;

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


}    