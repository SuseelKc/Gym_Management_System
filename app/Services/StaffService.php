<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\Staff;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\StaffRepository;
use App\Repositories\MemberRepository;

class StaffService
{
    public function __construct(StaffRepository $staffRepository,UserRepository $userRepository)
    {
        $this->staffRepository = $staffRepository;
        $this->userRepository = $userRepository;
    }

    public function all()
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $user_id=$user->id;
            // dd("Here");
            return $this->staffRepository->getAll()->where('gym_id',$user_id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(Message::Failed);
        }
    }

    public function add(Staff $staff,Request $request){
        try {
            
            DB::beginTransaction();
            $user = auth()->user();
            $gym=User::FindOrFail($user->id);
            $gymName = (string) $gym->name;
    
            // 
            $count=Staff::where('gym_id',$user->id)->count();
            if($count>1){
                $words = explode(' ', $gymName);
                $initials = ''; 
                for ($i = 0; $i < min(3, count($words)); $i++) {
                    $initials .= strtoupper($words[$i][0]);
                }
                $lastRecordMember=Staff::where('gym_id',$user->id)->latest()->first();
                $last_serialno=$lastRecordMember->serial_no;
                // aplabetic and numeric seperation
                $alphabeticalPart = preg_replace('/[^A-Za-z]/', '', $last_serialno);
                $numericPart = preg_replace('/[^0-9]/', '', $last_serialno);
                // 
                
                $serialNumber = "ST".$initials . sprintf('%03d', $numericPart + 1);
            }
        else{    
            $words = explode(' ', $gymName);
            $initials = '';
            for ($i = 0; $i < min(3, count($words)); $i++) {
                $initials .= strtoupper($words[$i][0]);
            }
            $serialNumber = "ST".$initials . sprintf('%03d', $count + 1);    
        }  
        
        $staff->name=$request->name;
        $staff->serial_no =  $serialNumber;
        $staff->gym_id =$user->id;
        $staff->dob=$request->dob;
        $staff->address=$request->address;
        $staff->contact_no=$request->contact_no;
        $staff->email=$request->email;
        $staff->position=$request->position;
       
        if ($request->hasFile('photo')) {
            $gallery = $request->file('photo');
            $extension = $gallery->getClientOriginalExtension();
            $filename = $gallery->getClientOriginalName() . '.' . $extension;
            $gallery->move('./images/staff/', $filename);
            $staff->photo = $filename;
        }
     

        $staff->save();   
       
        DB::commit();
        return $staff;
        } 
        catch (Exception $e) {
            DB::rollBack();
        // Log the error message
        \Log::info('Error during staff save: ' . $e->getMessage());
        // Display a generic error message to the user
        return redirect()->back()->with('error', 'An error occurred while saving the staff information.');
        }
    }
    
    public function delete($id){
        try{
            DB::beginTransaction();         
            $staff=$this->staffRepository->getById($id);
            if($staff->photo){
                $path='images/staff/'.$staff->photo;
                if(File::exists($path)){
                       File::delete($path);
                }
            }
            
            $staff->delete();
            DB::commit();
            return $staff;

        }
        catch(Exception $e){
            DB::rollBack();
        }
    }
    
    public function update(Staff $staff, $id, Request $request)
{
    try {
        DB::beginTransaction();

        $user = auth()->user();
   
        $staff->user_id = $user->id;
        $staff->name = $request->name;
        $staff->dob = $request->dob;      
        $staff->address = $request->address;
        $staff->contact_no = $request->contact_no;
        $staff->email = $request->email;
        $staff->position=$request->position;

        if ($request->hasFile('photo')) {

            $path='images/staff/'.$staff->photo;
            if(File::exists($path)){
                   File::delete($path);
            }


            $gallery = $request->file('photo');
            $extension = $gallery->getClientOriginalExtension();
            $filename = $gallery->getClientOriginalName() . '.' . $extension;
            $gallery->move('./images/staff/', $filename);
            $staff->photo = $filename;
        }

        $staff->update();

        DB::commit();
        return $staff;
        
    } catch (Exception $e) {
        DB::rollBack();
        // Log the error message
        Log::info('Error during member save: ' . $e->getMessage());
        // Display a generic error message to the user
        return redirect()->back()->with('error', 'An error occurred while saving the member information.');
    }
}
}
