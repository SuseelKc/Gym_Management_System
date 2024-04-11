<?php

namespace App\Http\Controllers\GymMember;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\MemberService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\MemberRepository;

class MemberProfileController extends Controller
{
    //
    public function __construct(MemberRepository $memberRepository,
    UserRepository $userRepository,
    MemberService $memberService,UserService $userService)
    {
        $this->userRepository=$userRepository;
        $this->memberRepository=$memberRepository;
        $this->memberService=$memberService;
        $this->userService=$userService;
        
    }
    public function index(){
        try{
            // dd("Hurray");
            $user=auth()->user();
            // dd($user->member_id);
            $member=$this->memberRepository->getById($user->member_id);
        
            // dd($member);
            return view('gymmember.profile.index',compact('member'));
        }
        catch(Exception $e){

        }
    }

    public function edit($id){

        try{
            $user=auth()->user();
            // dd($user->member_id);
            $member=$this->memberRepository->getById($user->member_id);

            return view('gymmember.profile.edit',compact('member'));

        }
        catch(Exception $e){

        }

    }




    public function update(Request $request,$id){
        try{
            // dd($request->all());
            $user=auth()->user();
            $user=$this->userRepository->getById($user->id);
            $member=$this->memberRepository->getById($user->member_id);
            $member=$this->memberService->updateMember($member,$request);
            $user=$this->userService->updateUser($user,$request);
            toast('Profile Updated Successfully!','success');
            return redirect()->intended(route('memberprofile'));

        }
        catch(Exception $e){

        }

    }
}
