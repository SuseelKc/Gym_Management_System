<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Enums\Shifts;
use App\Models\Ledger;
use App\Models\Member;
use App\Enums\UserRole;
use App\Models\Pricing;
use Illuminate\Http\Request;
use App\Services\LedgerService;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Repositories\LedgerRepository;
use App\Repositories\MemberRepository;
use App\Repositories\PricingRepository;

class MemberService
{
    public function __construct(MemberRepository $memberRepository,UserRepository $userRepository,LedgerService $ledgerService,PricingRepository $pricingRepository,
    LedgerRepository $ledgerRepository)
    {
        $this->memberRepository = $memberRepository;
        $this->userRepository = $userRepository;
        $this->ledgerService= $ledgerService;
        $this->pricingRepository=$pricingRepository;
        $this->ledgerRepository=$ledgerRepository;
    }

    public function all()
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $user_id=$user->id;
            return $this->memberRepository->getAll()->where('user_id',$user_id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(Message::Failed);
        }
    }



public function add(Member $member, Request $request)
{
    try {
        DB::beginTransaction();

        $user = auth()->user();
        $gym=User::FindOrFail($user->id);
        $gymName = (string) $gym->name;

        // 
        $count=Member::where('user_id',$user->id)->count();
        
        if($count>1){
                $words = explode(' ', $gymName);
                $initials = ''; 
                for ($i = 0; $i < min(3, count($words)); $i++) {
                    $initials .= strtoupper($words[$i][0]);
                }
                $lastRecordMember=Member::where('user_id',$user->id)->latest()->first();
                $last_serialno=$lastRecordMember->serial_no;
                // aplabetic and numeric seperation
                $alphabeticalPart = preg_replace('/[^A-Za-z]/', '', $last_serialno);
                $numericPart = preg_replace('/[^0-9]/', '', $last_serialno);
                // 
                $serialNumber = $initials . sprintf('%03d', $numericPart + 1);
            }
        else{    
            $words = explode(' ', $gymName);
            $initials = '';
            for ($i = 0; $i < min(3, count($words)); $i++) {
                $initials .= strtoupper($words[$i][0]);
            }
            $serialNumber = $initials . sprintf('%03d', $count + 1);    
        }  
        // 
        // dd($serialNumber);
        $member->serial_no =  $serialNumber;
        $member->user_id = $user->id;
        $member->name = $request->name;
        $member->dob = $request->dob;      
        $member->address = $request->address;
        $member->contact_no = $request->contact_no;
        $member->email = $request->email;
        $member->pricing_id = $request->pricing;

        if ($request->hasFile('photo')) {
            $gallery = $request->file('photo');
            $extension = $gallery->getClientOriginalExtension();
            $filename = $gallery->getClientOriginalName() . '.' . $extension;
            $gallery->move('./images/members/', $filename);
            $member->photo = $filename;
        }
       
        $pricing = $this->pricingRepository->getById($member->pricing_id);
        // dd($pricing);
        if( $pricing){ 
            $member->pricing_type=$pricing->costs_type;
            $member->pricing_date=Carbon::now();
        }
       
        $member->save();
        // if package(pricing)exists
        if( $member->pricing_id != null){
                      
            $this->ledgerService->add($member, $pricing);
                //   
        }

        //      

        DB::commit();
        return $member;
        
        
    } catch (Exception $e) {
        DB::rollBack();
        // Log the error message
        \Log::info('Error during member save: ' . $e->getMessage());
        // Display a generic error message to the user
        return redirect()->back()->with('error', 'An error occurred while saving the member information.');
    }
}

public function update(Member $member, $id, Request $request)
{
    try {
        DB::beginTransaction();

        $user = auth()->user();
   
        $member->user_id = $user->id;
        $member->name = $request->name;
        $member->dob = $request->dob;      
        $member->address = $request->address;
        $member->contact_no = $request->contact_no;
        $member->email = $request->email;
        


        if ($request->hasFile('photo')) {

            $path='images/members/'.$member->photo;
            if(File::exists($path)){
                   File::delete($path);
            }


            $gallery = $request->file('photo');
            $extension = $gallery->getClientOriginalExtension();
            $filename = $gallery->getClientOriginalName() . '.' . $extension;
            $gallery->move('./images/members/', $filename);
            $member->photo = $filename;
        }

        // when member's package/pricing is choosen(ledger creation)
   
       
        if( $member->pricing_id == null){
           
            $pricing = $this->pricingRepository->getById($request->pricing);
            
            if($pricing != null){
            $member->pricing_id = $request->pricing; 
            $member->pricing_type=$pricing->costs_type;
            $member->pricing_date=Carbon::now();
            $this->ledgerService->add($member, $pricing);
            }
                     
        }


        $member->update();

        DB::commit();
        return $member;
        
    } catch (Exception $e) {
        DB::rollBack();
        // Log the error message
        Log::info('Error during member save: ' . $e->getMessage());
        // Display a generic error message to the user
        return redirect()->back()->with('error', 'An error occurred while saving the member information.');
    }
}
// when updated by system admin
public function updateGymMember(Member $member, $id, Request $request)
{
    try {
        DB::beginTransaction();

        // $user = auth()->user();
   
        // $member->user_id = $user->id;
        $member->name = $request->name;
        $member->dob = $request->dob;      
        $member->address = $request->address;
        $member->contact_no = $request->contact_no;
        $member->email = $request->email;
        $member->pricing_id = $request->pricing;


        if ($request->hasFile('photo')) {

            $path='images/members/'.$member->photo;
            if(File::exists($path)){
                   File::delete($path);
            }


            $gallery = $request->file('photo');
            $extension = $gallery->getClientOriginalExtension();
            $filename = $gallery->getClientOriginalName() . '.' . $extension;
            $gallery->move('./images/members/', $filename);
            $member->photo = $filename;
        }

        // when member's package/pricing is choosen(ledger creation)
       

        if( $member->pricing_id != null){
        
            $pricing = $this->pricingRepository->getById($member->pricing_id);
            $member->pricing_type=$pricing->costs_type;
            $member->pricing_date=Carbon::now();
            $this->ledgerService->addGymMember($member, $pricing);
                     
        }


        $member->update();

        DB::commit();
        return $member;
        
    } catch (Exception $e) {
        DB::rollBack();
        // Log the error message
        Log::info('Error during member save: ' . $e->getMessage());
        // Display a generic error message to the user
        return redirect()->back()->with('error', 'An error occurred while saving the member information.');
    }
}

    public function delete($id){
        try{
            DB::beginTransaction();         
            $member=$this->memberRepository->getById($id);
            if($member->photo){
                $path='images/members/'.$member->photo;
                if(File::exists($path)){
                       File::delete($path);
                }
            }
            
            $member->delete();
            DB::commit();
            return $member;

        }
        catch(Exception $e){
            DB::rollBack();
        }
    }
    public function toggle($id){

        try {
            DB::beginTransaction();
            $member = $this->memberRepository->getById($id);
            
            if ($member->shifts == Shifts::Morning) {
                $member->shifts = Shifts::Day;
            } 
            elseif($member->shifts == Shifts::Day){
                $member->shifts = Shifts::Evening;
            }
            else {
                $member->shifts = Shifts::Morning;
            }
            $member->save();
            DB::commit();
            return $member;
        } catch (Exception $e) {
            DB::rollback();
            throw new Exception(Message::Failed);
        }

    }

    public function createMemberAccount($member){
        try{
            DB::beginTransaction();
            $user = new User();
            // dd($member);
            $user->name=$member->name;
            $user->email=$member->email;
            $user->password=bcrypt('12345678');
            $user->UserRole=UserRole::GymMember;
            $user->member_id=$member->id;
            $message = "Your account has been created successfully! Thanks for using GymManagerX.";
            Mail::raw($message, function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Account Creation Confirmation');
            });
            $user->save();
            DB::commit();
            return $user;

        }
        catch (Exception $e) {
            DB::rollback();
            throw new Exception(Message::Failed);
        }


    }

    
    public function updateMember(Member $member,Request $request){
        try{
            DB::beginTransaction();
          
            // dd($member);
            $member->name=$request->name;
            $member->dob=$request->dob;
            $member->address=$request->address;
            $member->save();
            DB::commit();
            return $member;

        }
        catch (Exception $e) {
            DB::rollback();
            throw new Exception(Message::Failed);
        }


    }
    
}
