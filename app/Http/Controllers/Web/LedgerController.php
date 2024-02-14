<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\LedgerService;
use App\Services\MemberService;
use App\Http\Controllers\Controller;

class LedgerController extends Controller
{
    //
    public function __construct(LedgerService $ledgerService,MemberService $memberService)
    {
        $this->ledgerService = $ledgerService;
        $this->memberService= $memberService;
       
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
            // dd($id);
            $members= $this->memberService->all()->ToArray();  
            return view('admin.ledger.index',compact('ledger','members'));
          
        }
        catch(Exception $e){

        }
    }

}
