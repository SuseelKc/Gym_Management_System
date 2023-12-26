<?php

namespace App\Services;

use Exception;
use App\Models\Member;
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

   public function add(Request $request){
        try{
            DB::beginTransaction();
            
            $member = new Member();
            $gym=auth()->id();
            $member->gym_name=$gym->name;
            $member->dob=$request->dob;
            $member->address=$request->address;
            $member->contact_no=$request->contact_no;
            $member->email=$request->email;
            $member->package=$request->package;
            
            if ($request->hasFile('gallery')) {
                $gallery = $request->file('gallery');
                $extension = $gallery->getClientOriginalExtension();
                $filename = $gallery->getClientOriginalName() . '.' . $extension;
                $gallery->move('./images/members', $filename);
                $member->gallery = $filename;
            }
            // $user=$this->userRepository->getAll();
           
            $member->save();
            DB::commit();
        }
        catch(Execption $e){
            DB::rollBack();
            throw new Exception(Message::Failed);
        }
   }




    
    
}
