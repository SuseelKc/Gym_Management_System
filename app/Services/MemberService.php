<?php

namespace App\Services;

use Exception;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use App\Repositories\MemberRepository;

class MemberService
{
    public function __construct(MemberRepository $memberRepository,UserRepository $userRepository)
    {
        $this->memberRepository = $memberRepository;
        $this->userRepository = $userRepository;
    }

    public function all()
    {
        try {
            DB::beginTransaction();
            return $this->memberRepository->getAll();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(Message::Failed);
        }
    }

   public function add(Member $member,Request $request){
        try{
            DB::beginTransaction();
            
            // $member = new Member();
            $gym_id=auth()->id();
            

            $member->gym_name=$request->gym_name;
            $member->name=$request->name;
            $member->dob=$request->dob;
          
            $member->address=$request->address;
            $member->contact_no=$request->contact_no;
            $member->email=$request->email;
            // $member->package=$request->package;
           
            if ($request->hasFile('photo')) {
                $gallery = $request->file('photo');
                $extension = $gallery->getClientOriginalExtension();
                $filename = $gallery->getClientOriginalName() . '.' . $extension;
                $gallery->move('./images/members', $filename);
                $member->gallery = $filename;
            }
            // $user=$this->userRepository->getAll();
            // dd("here");
            // dd($member->toArray());
            $member->save();
            
            DB::commit();
            return $member;
        }
        catch(Execption $e){
            DB::rollBack();
            throw new Exception(Message::Failed);
        }
   }




    
    
}
