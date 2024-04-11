<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\StaffRepository;
use App\Repositories\LedgerRepository;
use App\Repositories\MemberRepository;
use App\Repositories\PricingRepository;
use App\Repositories\ExpensesRepository;
use App\Repositories\EquipmentRepository;


class UserService
{
    public function __construct(UserRepository $userRepository,StaffRepository $staffRepository,
    EquipmentRepository $equipmentRepository,ExpensesRepository $expensesRepository,
    LedgerRepository $ledgerRepository,MemberRepository $memberRepository,
    PricingRepository $pricingRepository)
    {
        $this->userRepository = $userRepository;
        $this->staffRepository= $staffRepository;
        $this->equipmentRepository=$equipmentRepository;
        $this->expensesRepository=$expensesRepository;
        $this->ledgerRepository= $ledgerRepository;
        $this->memberRepository=$memberRepository;
        $this->pricingRepository=$pricingRepository;
    }

    public function all()
    {
        try {
            DB::beginTransaction();
            return $this->userRepository->getAll();
            DB::commit();
        } catch (Exception $e) {
            // DB::rollBack();
            // throw new Exception(Message::Failed);
        }
    }

  public function deleteGymAdmin($id){
    try{
        DB::beginTransaction();
        //staff    
        $staffs=$this->staffRepository->gymStaff($id);
       
        foreach ($staffs as $staff){
          
            if($staff->photo){
                $path='images/staff/'.$staff->photo;
                if(File::exists($path)){
                    File::delete($path);
                }
        }
        $staff->delete();
        }
        // 
        //equipment
        $equipments=$this->equipmentRepository->gymEquipment($id); 
        
        foreach($equipments as $equipment){
               
            if($equipment->image){
                    $path='images/equipments/'.$equipment->image;
                    if(File::exists($path)){
                        File::delete($path);
                    }
                }
        $equipment->delete();        
        }
        // 
        // expenses
        $expenses=$this->expensesRepository->gymExpenses($id); 
       
        foreach($expenses as $expense){
            $expense->delete();
        }

        // 
        //ledger
        $ledgers=$this->ledgerRepository->gymLedger($id);
        // dd($ledgers);
        foreach($ledgers as $ledger){
            $ledger->delete();
        }
        // members
        $members=$this->memberRepository->gymMembers($id);
        
        foreach($members as $member){

            if($member->photo){
                $path='images/members/'.$member->photo;
                if(File::exists($path)){
                       File::delete($path);
                }
            }
        $member->delete();    
        }
        // 
        // pricing
        $pricings= $this->pricingRepository->gymPricings($id);
        
        foreach($pricings as $pricing){
        $pricing->delete();
        }

        // users or gym
        $gym=$this->userRepository->getById($id);
        $gym->delete();
        // 
        DB::commit();
        return $gym;
    }
    catch (Exception $e){

    }

  }

  public function updateUser(User $user,Request $request){
    try{
        DB::beginTransaction();
      
        // dd($user);
        $user->name=$request->name;
       
      
        $user->save();
        DB::commit();
        return $user;

    }
    catch (Exception $e) {
        DB::rollback();
        throw new Exception(Message::Failed);
    }


}

// delete only gymmemebers as users 
public function deleteGymMember($user){
    try{
        DB::beginTransaction();
        foreach ($user as $user){
              
        $user->delete();
        }
        DB::commit();
        return $user;

    }
    catch (Exception $e) {
        DB::rollback();
        throw new Exception(Message::Failed);
    }


}


    
    
}
