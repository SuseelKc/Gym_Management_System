<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\LedgerService;
use App\Services\MemberService;
use App\Http\Controllers\Controller;
use App\Repositories\MemberRepository;

class LedgerController extends Controller
{
    //
    public function __construct(LedgerService $ledgerService,MemberService $memberService,MemberRepository $memberRepository)
    {
        $this->ledgerService = $ledgerService;
        $this->memberService= $memberService;
        $this->memberRepository=$memberRepository;
       
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
            // dd($ledger);
            return view('admin.ledger.search',compact('ledger','members','selectedMember'));
          
        }
        catch(Exception $e){

        }
    }

}
