<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Services\StaffService;
use App\Http\Controllers\Controller;
use App\Repositories\StaffRepository;

class StaffController extends Controller
{
    //

    public function __construct(StaffService $staffService,StaffRepository $staffRepository)
    {
        $this->staffService = $staffService;
        $this->staffRepository = $staffRepository;
       
    }

    public function index(Request $request){
        try{
            // dd("Here");
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
            return redirect()->intended(route('staffs.index'));
        }
        catch(Exception $e){
        
        }
    
    }

    public function delete($id){
        try{            
            $staff=Staff::FindOrFail($id);
            $staff=$this->staffService->delete($id);
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
            return redirect()->intended(route('staffs.index'));    
        }
        catch(Exception $e){

        }
    }

}
