<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Services\StaffService;
use App\Http\Controllers\Controller;
use App\Repositories\StaffRepository;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class StaffController extends Controller
{
    public function __construct(StaffService $staffService,StaffRepository $staffRepository)
    {
        $this->staffService = $staffService;
        $this->staffRepository = $staffRepository;
       
    }

    public function index(){
        try{
           
            $staff= $this->staffService->all();
            return view('admin.staff.index',compact('staff'));
        }
        catch(Exception $e){

        }
    }

    public function create(){
        try{

            $gym_id=auth()->id();
            $gym=User::FindOrFail($gym_id);
            return view('admin.staff.create',compact('gym'));
        }
        catch(Exception $e){

        }

    }

    public function store(Request $request){
        try{
            $staff= new Staff();        
            $staff= $this->staffService->add($staff,$request);
            toast('New Staff Created Successfully!','success');
            return redirect()->intended(route('staffs.index'));
        }
        catch (\Exception $e) {
            // If an exception occurs, log the error
            \Log::error('Error adding staff: ' . $e->getMessage());
            
            // Redirect back with error message and input data
            return redirect()->back()->withInput()->withErrors(['An error occurred while saving the staff information.']);
        }
    }

    public function delete($id){
        try{            
            $staff=Staff::FindOrFail($id);
            $staff=$this->staffService->delete($id);
            toast('Staff Deleted Successfully!','success');
            return redirect()->intended(route('staffs.index'));    
        }
        catch(Exception $e){

        }
    }

    public function edit($id){
        try{            
            $staff=Staff::FindOrFail($id);
            $gym_id=auth()->id();
            $gym=User::FindOrFail($gym_id);
            return view('admin.staff.edit',compact('staff','gym'));          
        }
        catch(Exception $e){

        }
    }

    public function update(Request $request,$id){
        try{            
            $staff=Staff::FindOrFail($id);
            $staff=$this->staffService->update($staff,$id,$request);
            toast('Staff Updated Successfully!','success');
            return redirect()->intended(route('staffs.index'));    
        }
        catch(Exception $e){

        }
    }

    public function staffIndex()
    {   
        $gym_id=auth()->id();
        $gym=User::FindOrFail($gym_id);
        return view('admin.staff.staff', compact('gym'));
    }

    public function listStaff()
    {
        try
        {   
            $gym_id = Auth::id();

            $basicQuery = " SELECT *
                FROM staffs 
                WHERE gym_id = $gym_id and status='active' ORDER BY id desc";

            $staffs = DB::select($basicQuery);

            $count = 1;
            $result = array();
            
            foreach ($staffs as $staff) 
            {
                $row = (array) $staff;

                $row['sn'] = $count;
                
                $photoHtml = $staff->photo == null ?
                '<img src="/images/defaultimage.jpg" style="width:65px; height:65px; float:left; border-radius:50%; margin-right:10px;">' :
                '<img src="/images/staff/' . $staff->photo . '" style="width:65px; height:65px; float:left; border-radius:50%; margin-right:10px;">';
                $row['photo'] = $photoHtml;

                $row['action'] = "
                    <a href='#' class='edit-staff-btn' data-id='$staff->id' title='Edit Staff'>
                        <i class='fas fa-edit fa-lg'></i>
                    </a>
                    <a href='#' class='delete-staff-btn' data-id='$staff->id' data-name='$staff->name' title='Delete Staff'>
                        <i class='fas fa-times-circle fa-lg' style='color: red;'></i>
                    </a>
                ";

                $result[] = $row;
                
                $count++;
            }

            return response()->json([
                "draw" => intval(request()->input('draw')),
                "recordsTotal" => count($staffs),
                "recordsFiltered" => count($staffs),
                "data" => $result
            ]);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function saveStaff(Request $request)
    {
        try
        {   
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'dob' => 'required|date',
                'address' => 'required|string|max:255',
                'contact_no' => 'required|max:10',
                'email' => 'required|email|max:255',
                'position' => 'required',
            ]);

            if ($validator->fails()) 
            {
                return response()->json(['errors' => $validator->errors()], 422);
            }

           $staff= new Staff();        
           $staff= $this->staffService->add($staff,$request);
           
           return response()->json(['success' => 'Staff added successfully.'], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDataForStaffEdit($id)
    {
        try
        {       
            $staff=Staff::FindOrFail($id);
            $userName = $staff->user->name;
  
            return response()->json(['success' => true, 'staff' => $staff, 'userName' => $userName], 200);      
        }
        catch(Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStaff(Request $request)
    {
        try
        { 
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'dob' => 'required|date',
                'address' => 'required|string|max:255',
                'contact_no' => 'required|max:10',
                'email' => 'required|email|max:255',
                'position' => 'required',
                'staff_id'  => 'required',
            ]);

            if ($validator->fails()) 
            {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $id = $request->staff_id;
            $staff=Staff::FindOrFail($id);
            $staff = $this->staffService->update($staff, $id, $request);
         
            return response()->json(['success' => 'staff saved successfully.'], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteStaff($id)
    {
        try
        { 
            $staff = Staff::findOrFail($id);

            $staff->status = 'deleted';
            $staff->save();
            
            return response()->json(['success' => 'Staff Deleted Successfully.'], 200);
        }
        catch(Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}