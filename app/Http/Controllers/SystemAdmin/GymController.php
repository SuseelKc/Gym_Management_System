<?php

namespace App\Http\Controllers\SystemAdmin;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\MemberRepository;

class GymController extends Controller
{
    //
    public function __construct(UserRepository $userRepository,UserService $userService,
    MemberRepository $memberRepository)
    {
        $this->userRepository = $userRepository;
        $this->userService=$userService;
        $this->memberRepository=$memberRepository;
    }


    public function index(){
        try{
            $gyms=$this->userRepository->getGymAdmin();         
            return view('systemadmin.gym.index',compact('gyms'));
        }
        catch(Exception $e){


        }
    }

    public function delete($id){
        try{
            $members=$this->memberRepository->gymMembers($id);
            foreach($members as $member){
            $memberUser = $this->userRepository->getGymMember($member->id);


            if ($memberUser->isNotEmpty()) {
                toast("Memeber exists as users remove them to remove this gym!",'error');
                // dd("Here");
                return redirect()->back();
              
            }
        }

            $gym=$this->userService->deleteGymAdmin($id);
            toast('Gym Deleted Successfully!','success');
            return redirect()->intended(route('gym.index')); 
        }
        catch(Exception $e){

        }
    }
}
