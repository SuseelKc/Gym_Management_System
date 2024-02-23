<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Ledger;
use App\Models\Member;
use App\Models\Pricing;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Services\EquipmentService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Mime\Message;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\LedgerRepository;
use App\Repositories\MemberRepository;
use App\Repositories\PricingRepository;
use App\Repositories\EquipmentRepository;

class LedgerService
{
    public function __construct(LedgerRepository $ledgerRepository,PricingRepository $pricingRepository)
    {       
        $this->ledgerRepository = $ledgerRepository;
        $this->pricingRepository = $pricingRepository;
    }

    public function all()
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $user_id=$user->id;
            return $this->ledgerRepository->getAll()->where('gym_id',$user_id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(Message::Failed);
        }
    }


    public function search($id){
        try{
            DB::beginTransaction();
            $user = auth()->user();
            $user_id=$user->id;
            $ledger= $this->ledgerRepository->getAll()->where('member_id',$id);
            DB::commit();
            return $ledger;
        }
        catch(Exception $e){
            DB::rollBack();
            throw new Exception(Message::Failed);
        }


    }

    public function add(Member $member, Pricing $pricing)
    {
        try {
            
            $ledger = new Ledger();
            $ledger->date = Carbon::now();
            $ledger->debit = $pricing->costs;
            $ledger->balance = $pricing->costs;
            $ledger->member_id = $member->id;
            $ledger->gym_id = auth()->id();
            $ledger->save();
            return $ledger;
        } catch (Exception $e) {
            throw new Exception("Failed to add ledger entry: " . $e->getMessage());
        }
    }

    public function addMemberPayment(Member $selectedMember, Request $request, Ledger $recentBalance)
    {
        try {
            DB::beginTransaction();
           
            $ledger = new Ledger();
            $ledger->date = Carbon::now();      
            $ledger->credit = number_format($request->amt_paid, 3, '.', '');       
            $ledger->receipt_no = $request->receipt_no;  
            
            $ledger->remarks = $request->remarks;             
            $newBalance = ($recentBalance->balance) - ($request->amt_paid);    
            $ledger->balance = number_format($newBalance, 3, '.', '');
            $ledger->member_id = $selectedMember->id;        
            $ledger->gym_id = auth()->id();
             
            $ledger->save();
            
            DB::commit();
            
            return $ledger;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error in addMemberPayment: ' . $e->getMessage());
            return null; // Return null to indicate failure
        }
    }
    
    public function deleteMemberLedger($ledgerId){
        try{
            DB::beginTransaction();
     
            $ledger=$this->ledgerRepository->getById($ledgerId);
            
            $ledger->delete();
          
           
            DB::commit();
            return $ledger;
        }
        catch (Exception $e){
            DB::rollBack();
            Log::error('Error in deleteMemberLedger: ' . $e->getMessage());
            return null; // Return null to indicate failure
        }

    }

 
}    