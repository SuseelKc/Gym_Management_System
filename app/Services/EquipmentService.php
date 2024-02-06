<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
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
        $user_id = $user->id;

        // for increasing upcoming date if upcoming date is today
        $todayDate = Carbon::now();

        $datesEqual = Equipment::whereDate('upcoming_date', $todayDate)
            ->where('gym_id', $user_id)
            ->get();

        if ($datesEqual->isNotEmpty()) {
            foreach ($datesEqual as $equipment) {
                // Check maintenance_type and update upcoming_date accordingly
                if ($equipment->maintenance_type === 'Year') {
                    $equipment->upcoming_date = Carbon::now()->addYears($equipment->maintenance_period);
                } elseif ($equipment->maintenance_type === 'Month') {
                    $equipment->upcoming_date = Carbon::now()->addMonths($equipment->maintenance_period);
                } else {
                    $equipment->upcoming_date = Carbon::now()->addDays($equipment->maintenance_period);
                }

                // Save the changes to the database
                $equipment->update();
            }
        }

        // The rest of your code
        // $result = $this->equipmentRepository->getAll()->where('gym_id', $user_id);

        DB::commit();
        return $this->equipmentRepository->getAll()->where('gym_id', $user_id);
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
            
    
        $count=Equipment::where('gym_id',$user->id)->count();   
       
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
        $equipment->qty = $request->qty;
        $equipment->gym_id = $user->id;
        $equipment->name = $request->name;
    
        if($request->maintenance_period){

                if ($request->maintenance_type === 'year') {
                   
                    $equipment->maintenance_period = $request->maintenance_period;
                    $equipment->maintenance_type = "Year";

                    
                    $upcomingDate = Carbon::now()->addYears($request->maintenance_period);
                    
                    // Assign the calculated date to the upcoming_date property
                    $equipment->upcoming_date = $upcomingDate;

                } elseif ($request->maintenance_type === 'month') {
                   
                    $equipment->maintenance_period = $request->maintenance_period;
                    $equipment->maintenance_type = "Month";

                    $upcomingDate = Carbon::now()->addMonth($request->maintenance_period);
                    
                    // Assign the calculated date to the upcoming_date property
                    $equipment->upcoming_date = $upcomingDate;

                } else {

                    $equipment->maintenance_period = $request->maintenance_period;
                    $equipment->maintenance_type = "Days";

                    $upcomingDate = Carbon::now()->addDays($request->maintenance_period);
                    
                    // Assign the calculated date to the upcoming_date property
                    $equipment->upcoming_date = $upcomingDate;
                }

        }
        
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

    public function update(Equipment $equipment,$id,Request $request ){

        try{
            DB::beginTransaction();
            $user = auth()->user();
            $equipment->gym_id = $user->id;
            $equipment->name= $request->name;
            $equipment->weight =  $request->weight;
            $equipment->qty = $request->qty;

            if($request->maintenance_period== 0 || empty($request->maintenance_period) ){

                $equipment->maintenance_type= null;
                $equipment->maintenance_period= null; 
                $equipment->upcoming_date= null; 
            }    
            
          

            if($request->maintenance_period){

                if ($request->maintenance_type === 'year') {
                   
                    $equipment->maintenance_period = $request->maintenance_period;
                    $equipment->maintenance_type = "Year";
                    $addedDate = Carbon::parse($equipment->created_at);                  
                    $upcomingDate =  $addedDate->addYears($request->maintenance_period);
                    
                    // Assign the calculated date to the upcoming_date property
                    $equipment->upcoming_date = $upcomingDate;

                } elseif ($request->maintenance_type === 'month') {
                   
                    $equipment->maintenance_period = $request->maintenance_period;
                    $equipment->maintenance_type = "Month";
                    $addedDate = Carbon::parse($equipment->created_at);
                    $upcomingDate = $addedDate->addMonth($request->maintenance_period);
                    
                    // Assign the calculated date to the upcoming_date property
                    $equipment->upcoming_date = $upcomingDate;

                } else {

                    $equipment->maintenance_period = $request->maintenance_period;
                    $equipment->maintenance_type = "Days";
                    $addedDate = Carbon::parse($equipment->created_at);
                    $upcomingDate = $addedDate->addDays($request->maintenance_period);                    
                    // Assign the calculated date to the upcoming_date property
                    $equipment->upcoming_date = $upcomingDate;
                }

        }
                      
            if ($request->hasFile('photo')) {

                $path='images/equipments/'.$equipment->image;
                if(File::exists($path)){
                       File::delete($path);
                }

    
                $gallery = $request->file('photo');
                $extension = $gallery->getClientOriginalExtension();
                $filename = $gallery->getClientOriginalName() . '.' . $extension;
                $gallery->move('./images/equipments/', $filename);
                $equipment->photo = $filename;
            }

            $equipment->update();
            DB::commit();
            return $equipment;
        }
        catch(Exception $e){
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
            $equipment=$this->equipmentRepository->getById($id);
            if($equipment->image){
                $path='images/equipments/'.$equipment->image;
                if(File::exists($path)){
                       File::delete($path);
                }
            }
            
            $equipment->delete();
            DB::commit();
            return $equipment;

        }
        catch(Exception $e){
            DB::rollBack();
        }
    }

    
}
