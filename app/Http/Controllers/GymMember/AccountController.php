<?php

namespace App\Http\Controllers\GymMember;

use Carbon\Carbon;
use App\Models\Ledger;
use App\Models\Member;
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

   

    public function verify(Request $request)
    {
        $args = http_build_query(array(
            'token' =>$request->payload['token'],
            'amount'  => $request->payload['amount']
          ));
          
          $url = "https://khalti.com/api/v2/payment/verify/";
          
          # Make the call using API.
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          
          $headers = ['Authorization: Key test_secret_key_552708bf69d24237a561bbca5e13bca3'];
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          
          // Response
          $response = curl_exec($ch);
          $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          curl_close($ch);

          if($status_code == 200)
          {
            $payload = $request->payload;
            $memberId = $request->member_id;
            $ledgerId = $request->ledger_id;

            $latestRecord = Ledger::where('member_id', $memberId)->latest()->first();
            $recentBalance = $latestRecord ? $latestRecord->balance : 0;
            $newBalance = $recentBalance - ($payload['amount']/100); 

            $member = Member::findOrFail($memberId);
            $gymId= $member->user_id;


            
                  
            $payment = Ledger::create([
                'credit' => ($payload['amount']/100),
                'date'=>Carbon::now(),
                'balance'=>$newBalance,
                'member_id'=>$memberId,
                'gym_id'=> $gymId,
       
                'remarks'=>"Paid By Khalti"
         
            ]);

            
            return response()->json(['message' => 'Payment verified and stored successfully'], 200);
          }
          else
          {
            return response()->json([
                'message' => 'Payment failed!',
                'status_code' => $status_code,
                'response' => $response
            ], 400);    
          }
    }

    public function storePayment(Request $request){
        dd($request);

    }

}
