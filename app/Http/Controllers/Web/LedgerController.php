<?php

namespace App\Http\Controllers\Web;


use App\Models\Ledger;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\LedgerService;
use App\Services\MemberService;
use App\Http\Controllers\Controller;
use App\Repositories\LedgerRepository;
use App\Repositories\MemberRepository;

class LedgerController extends Controller
{
    //
    public function __construct(LedgerService $ledgerService,MemberService $memberService,MemberRepository $memberRepository,LedgerRepository $legderRepository)
    {
        $this->ledgerService = $ledgerService;
        $this->memberService= $memberService;
        $this->memberRepository=$memberRepository;
        $this->legderRepository=$legderRepository;
       
    }
    public function index(){
        try{
            $ledger=$this->ledgerService->all(); 
            $members= $this->memberService->all()->ToArray();                   
            return view('admin.ledger.index',compact('ledger','members'));
        }
        catch(Exception $e){

        }
    }
    public function search($id){
        try{           
            $ledger=$this->ledgerService->search($id);
            $selectedMember=$this->memberRepository->getById($id);          
            $members= $this->memberService->all()->ToArray();  
            return view('admin.ledger.search',compact('ledger','members','selectedMember'));
          
        }
        catch(Exception $e){

        }
    }

    public function storeMemberPayment($id,Request $request){
        try{
                    
            $ledger= new Ledger();
            $selectedMember=$this->memberRepository->getById($id);  
            $recentBalance=$this->ledgerService->all()->where('member_id',$id)->sortByDesc('created_at')->first();
            if($recentBalance == null){
                toast("Member has not purchased package!",'warning');
                return redirect()->back();
            }
            $ledger = $this->ledgerService->addMemberPayment($ledger,$selectedMember,$request,$recentBalance);
            // dd($ledger);
            toast('Member Payment Added Successfully!','success');
            return redirect()->back();

        }
        catch(Exception $e){

        }

    }

}
