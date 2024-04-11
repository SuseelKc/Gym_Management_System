<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\LedgerService;
use App\Services\MemberService;
use App\Services\PricingService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\LedgerRepository;
use App\Repositories\MemberRepository;

class MemberController extends Controller
{
    //
    public function __construct(MemberService $memberService,MemberRepository $memberRepository,PricingService $pricingService,UserRepository $userRepository,
    LedgerService $ledgerService,LedgerRepository $ledgerRepository,UserService $userService)
    {
        $this->memberService = $memberService;
        $this->memberRepository = $memberRepository;
        $this->ledgerRepository = $ledgerRepository;
        $this->userRepository = $userRepository;
        $this->pricingService =$pricingService;
        $this->ledgerService =$ledgerService;
        $this->userService =$userService;
    }

    public function index(Request $request){
        try{
            $member=$this->memberService->all();          
            return view('admin.member.index',compact('member'));
        }
        catch(Exception $e){

        }

    }

    public function create(){
        try{
            
            $gym_id=auth()->id();
            $gym=User::FindOrFail($gym_id);
            $pricing = $this->pricingService->all();             
            return view('admin.member.create',compact('gym','pricing'));
           
        }
        catch(Exception $e){

        }
    }

    public function store(Request $request){
        try{
           $member= new Member();        
           $member= $this->memberService->add($member,$request);
           toast('New Member Added Successfully!','success');
           return redirect()->intended(route('member.index'));
           
        }
        catch(Exception $e){

        }
    }

    public function edit($id){
        try{            
            $member=Member::FindOrFail($id);
            $pricing = $this->pricingService->all(); 
            $user=$this->userRepository->getGymMember($id);
            // dd($user);
            return view('admin.member.edit',compact('member','pricing','user'));          
        }
        catch(Exception $e){

        }
    }

    public function update(Request $request,$id){
        try{            
            $member=Member::FindOrFail($id);
            $member=$this->memberService->update($member,$id,$request);
            toast('Member Updated Successfully!','success');
            return redirect()->intended(route('member.index'));    
        }
        catch(Exception $e){

        }
    }

    public function delete($id){
        try{            
            $member=Member::FindOrFail($id);
            
            $memberId=$id;
           
            $ledgers= $this->ledgerRepository->getMember($memberId);
           
            if(!$ledgers ->isEmpty()){ //if ledger is not empty
                
                foreach($ledgers as $ledger){
                   
                $ledgerId=$ledger->id;   
              
                $ledger=$this->ledgerService->deleteMemberLedger($ledgerId);
                }
                $member=$this->memberService->delete($id);
                toast('Member & Other Details Deleted Successfully!','success');
                return redirect()->intended(route('member.index'));  
            }
            $user=$this->userRepository->getGymMember($id);
            if(!$user->isEmpty()){
               
                // $user->member_id= null;
                $user=$this->userService->deleteGymMember($user);
            }
            $member=$this->memberService->delete($id);
            toast('Member Deleted Successfully!','success');
            return redirect()->intended(route('member.index'));    
        }
        catch(Exception $e){

        }
    }

    public function toggle($id){
        try{            
            $member=Member::FindOrFail($id);
            $member=$this->memberService->toggle($id);
            toast('Member Shift Changed Successfully!','success');
            return redirect()->intended(route('member.index'));    
        }
        catch(Exception $e){

        }
    }

    public function renwewmembership(){
        try{
            $member=$this->memberService->all()->where('pricing_id',null)->where('pricing_type',null)->where('pricing_date',null);   
            return view('admin.member.renew',compact('member')); 
        }
        catch(Exception $e){

        }
    }

    public function createAccount($id){
        try{
            $member= $this->memberRepository->getById($id);
            $member=$this->memberService->createMemberAccount($member);
            toast('Member Account Created Successfully!','success');
            return redirect()->intended(route('member.index'));
        }
        catch(Exception $e){

        }
    }
}
