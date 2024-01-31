<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\Member;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Services\EquipmentService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Mime\Message;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\MemberRepository;
use App\Repositories\EquipmentRepository;

class EquipmentService
{
    public function __construct(EquipmentRepository $equipmentRepository)
    {       
        $this->equipmentRepository = $equipmentRepository;
    }

    public function all()
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $user_id=$user->id;
            return $this->equipmentRepository->getAll()->where('gym_id',$user_id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(Message::Failed);
        }
    }

    public function add(Equipment $equipment,Request $request){

        try{
         DB::beginTransaction();
         $user=auth()->user();
         $gym=User::FindOrFail($user->id);
         $equipmentName=(string) $request->name; 

        // count
        $count=Equipment::where('gym_id',$user->id)->count();   
        // 
        if($count>1){
            $words = explode(' ', $equipmentName);
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
            $words = explode(' ', $equipmentName);
            $initials = '';
            for ($i = 0; $i < min(3, count($words)); $i++) {
                $initials .= strtoupper($words[$i][0]);
            }
            $serialNumber = $initials . sprintf('%03d', $count + 1);   
        }

        $equipment->serial_no =  $serialNumber;
        $equipment->weight =  $request->weight;
        $equipment->gym_id = $user->id;
        $equipment->name = $request->name;
        // $equipment->dob = $request->dob;      
        $equipment->maintenance_period = $request->maintenance_period;
        $equipment->upcoming_date = $request->upcoming_date;
        
        if ($request->hasFile('photo')) {
            $gallery = $request->file('photo');
            $extension = $gallery->getClientOriginalExtension();
            $filename = $gallery->getClientOriginalName() . '.' . $extension;
            $gallery->move('./images/equipments/', $filename);
            $equipment->image = $filename;
        }

        $equipment->save();

        DB::commit();
        return $equipment;

        }
        catch(Exception $e){
            DB::rollBack();
            throw new Exception(Message::Failed);
        }

    }
    
}
