<?php

namespace App\Http\Controllers\SystemAdmin;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\LedgerService;
use App\Services\MemberService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\LedgerRepository;
use App\Repositories\MemberRepository;
use App\Repositories\PricingRepository;

class GymMemberController extends Controller
{
    //
    public function __construct(MemberRepository $memberRepository,PricingRepository $pricingRepository,
    MemberService $memberService,LedgerRepository $ledgerRepository,
    LedgerService $ledgerService,UserRepository $userRepository,
    UserService $userService)
    {
       $this->memberRepository=$memberRepository;
       $this->pricingRepository=$pricingRepository;
       $this->memberService=$memberService;
       $this->ledgerRepository=$ledgerRepository;
       $this->ledgerService=$ledgerService;
       $this->userRepository=$userRepository;
       $this->userService=$userService;
      
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
                // 
                $user=$this->userRepository->getGymMember($id);
                if(!$user->isEmpty()){
                   
                    // $user->member_id= null;
                    $user=$this->userService->deleteGymMember($user);
                }
                // 
                $member=$this->memberService->delete($id);
                toast('Member & Other Details Deleted Successfully!','success');
                return redirect()->intended(route('member.index'));  
            }
            // 
            $user=$this->userRepository->getGymMember($id);
            if(!$user->isEmpty()){
               
                // $user->member_id= null;
                $user=$this->userService->deleteGymMember($user);
            }
            // 
            $member=$this->memberService->delete($id);
            toast('Member Deleted Successfully!','success');
            return redirect()->intended(route('membersgym.index')); 

        }
        catch(Exception $e){

        }
    }

    public function getDetails(){
        try{
           
        $members=DB::select("SELECT * FROM members");
        return view('systemadmin.members.members',compact('members'));

        

        }
        catch(Exception $e){

        }
    }

    public function getMemberDetails($id)
    {
        $member = Member::find($id);
        $ledgerEntries = DB::select("SELECT * FROM Ledger WHERE member_id = ?", [$id]);

        if ($member) {
            return response()->json([
                'success' => true,
                'member' => $member,
                // 'ledger' => $ledgerEntries
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Member not found.'
            ]);
        }
    }
    
    public function fetchLedger($id)
    {
        try {
            // Fetch the ledger entries for the given member ID
            $ledgerEntries = DB::select("SELECT * FROM Ledger WHERE member_id = ?", [$id]);

        
            if (!empty($ledgerEntries)) {
                return response()->json([
                    'success' => true, 
                    'ledger' => $ledgerEntries
                ]);
            } else {
                
                return response()->json([
                    'success' => false, // Operation was not successful
                    'message' => 'No ledger entries found for the given member.' // Error message
                ]);
            }
        } catch (Exception $e) {
        
            return response()->json([
                'success' => false, // Operation failed
                'message' => 'An error occurred while fetching the ledger entries.', // Generic error message
                'error' => $e->getMessage() // Include the actual error message for debugging (optional)
            ]);
        }
    }

}
