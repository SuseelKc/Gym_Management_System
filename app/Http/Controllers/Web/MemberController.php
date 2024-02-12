<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\MemberService;
use App\Services\PricingService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\MemberRepository;

class MemberController extends Controller
{
    //
    public function __construct(MemberService $memberService,MemberRepository $memberRepository,PricingService $pricingService,UserRepository $userRepository)
    {
        $this->memberService = $memberService;
        $this->memberRepository = $memberRepository;
        $this->userRepository = $userRepository;
        $this->pricingService =$pricingService;
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
           toast('Member Added Successfully!','success');
           return redirect()->intended(route('member.index'));
           
        }
        catch(Exception $e){

        }
    }

    public function edit($id){
        try{            
            $member=Member::FindOrFail($id);
            $pricing = $this->pricingService->all(); 
            return view('admin.member.edit',compact('member','pricing'));          
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

}
