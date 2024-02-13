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
            $member= $this->memberService->all()->ToArray(); 
            // dd($member);        
            return view('admin.ledger.index',compact('ledger','member'));
        }
        catch(Exception $e){

        }
    }

}
