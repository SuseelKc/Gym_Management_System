<?php

namespace App\Http\Controllers\GymMember;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\MemberService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\LedgerRepository;
use App\Repositories\MemberRepository;

class AccountController extends Controller
{
   //
   public function __construct(MemberRepository $memberRepository,
   UserRepository $userRepository,LedgerRepository $ledgerRepository,
   MemberService $memberService,UserService $userService)
   {
       $this->userRepository=$userRepository;
       $this->memberRepository=$memberRepository;
       $this->memberService=$memberService;
       $this->userService=$userService;
       $this->ledgerRepository=$ledgerRepository;
       
   }

   public function index(){
    try{
        // dd("Here");
        $user=auth()->user();
        $user=$this->userRepository->getById($user->id);
        // $member=$this->memberRepository->gymMembers($user->member_id);
        $ledger=$this->ledgerRepository->getByMemberId($user->member_id);
        return view('gymmember.account.index',compact('ledger'));
    }
    catch(Exception $e){

    }


   }
}
