<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\MemberService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\MemberRepository;

class MemberController extends Controller
{
    //
    public function __construct(MemberService $memberService,MemberRepository $memberRepository,UserRepository $userRepository)
    {
        $this->memberService = $memberService;
        $this->memberRepository = $memberRepository;
        $this->userRepository = $userRepository;
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
            return view('admin.member.create',compact('gym'));
           
        }
        catch(Exception $e){

        }
    }

    public function store(Request $request){
        try{
           $member= new Member();        
           $member= $this->memberService->add($member,$request);
           return redirect()->intended(route('member.index'));
           
        }
        catch(Exception $e){

        }
    }

    public function edit($id){
        try{            
            $member=Member::FindOrFail($id);
            // dd($member);
            return view('admin.member.edit',compact('member'));          
        }
        catch(Exception $e){

        }
    }

    public function update(Request $request,$id){
        try{            
            $member=Member::FindOrFail($id);
            $member=$this->memberService->update($member,$id,$request);
            return redirect()->intended(route('member.index'));    
        }
        catch(Exception $e){

        }
    }

    public function delete($id){
        try{            
            $member=Member::FindOrFail($id);
            $member=$this->memberService->delete($id);
            return redirect()->intended(route('member.index'));    
        }
        catch(Exception $e){

        }
    }
}
