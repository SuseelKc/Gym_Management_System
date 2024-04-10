<?php

namespace App\Http\Controllers\SystemAdmin;

use Illuminate\Http\Request;
use App\Services\LedgerService;
use App\Services\MemberService;
use App\Http\Controllers\Controller;
use App\Repositories\LedgerRepository;
use App\Repositories\MemberRepository;
use App\Repositories\PricingRepository;

class GymMemberController extends Controller
{
    //
    public function __construct(MemberRepository $memberRepository,PricingRepository $pricingRepository,
    MemberService $memberService,LedgerRepository $ledgerRepository,
    LedgerService $ledgerService)
    {
       $this->memberRepository=$memberRepository;
       $this->pricingRepository=$pricingRepository;
       $this->memberService=$memberService;
       $this->ledgerRepository=$ledgerRepository;
       $this->ledgerService=$ledgerService;
      
    }

    public function index(){
        try{
            
            $gymMembers= $this->memberRepository->getAll();
            // dd($gymMembers);
            return view('systemadmin.members.index',compact('gymMembers'));
        }
        catch(Exception $e){


        }
    }
    public function edit($id){
        try{
            $member=$this->memberRepository->getById($id);
            $gymId=$member->user_id;
            $pricing = $this->pricingRepository->gymPricings($gymId);
            return view('systemadmin.members.edit',compact('member','pricing'));
        }
        catch(Exception $e){

        }

    }

    public function update(Request $request,$id){
        try{
            $member=$this->memberRepository->getById($id);
            $member=$this->memberService->updateGymMember($member,$id,$request);
            return redirect()->route('membersgym.index');
        }
        catch(Exception $e){

        }
    }


    public function delete($id){
        try{
           
            $member=$this->memberRepository->getById($id);
           
            $memberId=$id;
           
            $ledgers= $this->ledgerRepository->getByMemberId($memberId);
            // dd($ledgers);
            if(!$ledgers ->isEmpty()){ //if ledger is not empty
                
                foreach($ledgers as $ledger){
                   
                $ledgerId=$ledger->id;   
              
                $ledger=$this->ledgerService->deleteMemberLedger($ledgerId);
                }
                $member=$this->memberService->delete($id);
                toast('Member & Other Details Deleted Successfully!','success');
                return redirect()->intended(route('member.index'));  
            }

            $member=$this->memberService->delete($id);
            toast('Member Deleted Successfully!','success');
            return redirect()->intended(route('membersgym.index')); 

        }
        catch(Exception $e){

        }
    }
}
