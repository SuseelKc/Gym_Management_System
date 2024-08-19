<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\User;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Services\MemberService;
use App\Services\EquipmentService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\MemberRepository;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\EquipmentRepository;
use Illuminate\Support\Facades\Validator;

class EquipmentsController extends Controller
{
    //

    public function __construct(MemberService $memberService,MemberRepository $memberRepository,EquipmentService $equipmentService)
    {
        $this->memberService = $memberService;
        $this->memberRepository = $memberRepository;
        $this->equipmentService = $equipmentService;
       
    }

    public function index(Request $request){     
        try{       
            $equipment=$this->equipmentService->all();
            $gym_id=auth()->id();
            $gym=User::FindOrFail($gym_id);
            return view('admin.equipments.equipment',compact('equipment','gym'));
        }
        catch(Exception $e){

        }

    }

    public function create(){
        try{
            
            $gym_id=auth()->id();
            $gym=User::FindOrFail($gym_id);
            return view('admin.equipments.create',compact('gym'));
           
        }
        catch(Exception $e){

        }
    }

    public function store(Request $request){
        try{
           $equipment= new Equipment();
          
           $equipment= $this->equipmentService->add($equipment,$request);
           toast('Equipment Added Successfully!','success');
     
           return redirect()->intended(route('equipments.index'));
           
        }
        catch(Exception $e){

        }
    }

    public function edit($id){
        try{
           $equipment=Equipment::FindOrFail($id);           
           $gym_id=auth()->id();
           $gym=User::FindOrFail($gym_id);
           return view('admin.equipments.edit',compact('equipment','gym')); 
           
        }
        catch(Exception $e){

        }
    }

    public function update(Request $request,$id){
        try{

            $equipment=Equipment::FindOrFail($id);
            $equipment=$this->equipmentService->update($equipment,$id,$request);
            toast('Equipment Updated Successfully!','success');
            return redirect()->intended(route('equipments.index'));

        }
        catch(Exception $e){

        }
    }
    
    public function delete($id){
        try{            
            $equipment=Equipment::FindOrFail($id);
            $equipment=$this->equipmentService->delete($id);
            toast('Equipment Deleted Successfully!','success');
            return redirect()->intended(route('equipments.index'));    
        }
        catch(Exception $e){

        }
    }

    //function that fetches equipment to the table
    public function fetchEquipments() {
        try {
            $gym_id = Auth::id();
    
            $equipments = DB::select('SELECT * FROM equipments WHERE gym_id = ? ORDER BY id DESC', [$gym_id]);
    
            if (empty($equipments)) {
                return response()->json([
                    "draw" => intval(request()->input('draw')),
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                    "data" => []
                ]);
            }
    
            $result = [];
            $count = 1;
    
            foreach($equipments as $equipment) {
                $row = (array) $equipment;
                $row['sn'] = $count;
                $row['image'] = $equipment->image ? 
                    "<img src='/images/equipments/{$equipment->image}' style='width:65px; height:65px; float:left; border-radius:50%; margin-right:10px;'>" :
                    "<img src='/images/defaultimage.jpg' style='width:65px; height:65px; float:left; border-radius:50%; margin-right:10px;'>";
    
                $row['action'] = "
                    <a href='#' class='edit-equipment-btn' data-id='{$equipment->id}' title='Edit Equipment'>
                        <i class='fas fa-edit fa-lg'></i>
                    </a>
                    <a href='#' class='delete-equipment-btn' data-id='{$equipment->id}' data-name='{$equipment->name}' title='Delete Equipment'>
                        <i class='fas fa-times-circle fa-lg' style='color: red;'></i>
                    </a>
                ";
                $result[] = $row;
                $count++;
            }
    
            return response()->json([
                "draw" => intval(request()->input('draw')),
                "recordsTotal" => count($equipments),
                "recordsFiltered" => count($equipments),
                "data" => $result
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in fetchEquipments: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function saveEquipment(Request $request){
        try{
          
            $validator =Validator::make($request->all(),[
                
                'name' => 'required|string|max:255',
                'weight' => 'required|numeric|min:0', 
                'qty' => 'required|integer|min:1', 
                'maintenance_period' => 'required|integer|min:1|max:10', 
                'maintenance_type' => 'required|in:year,month,days', 
                //'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            if ($validator->fails()){
                return response()->json(['errors'=>$validator->errors()],422);
            }
            $equipment = new Equipment();
         
            $equipment=$this->equipmentService->add($equipment,$request);
            return response()->json(['success'=>'Equipment added successfully'],200);
            

        }
        catch(Exception $e){

            return response()->json(['error' => $e->getMessage()], 500);
        }

    }



    public function editEquipment($id)
    {
        try
        {       
            $equipment = Equipment::FindOrFail($id);
            $userName = $equipment->user->name;
    
            return response()->json(['success' => true, 'equipment' => $equipment, 'userName' => $userName], 200);      
        }
        catch(Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
