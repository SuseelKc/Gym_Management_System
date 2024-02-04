<?php

namespace App\Http\Controllers\Web;

use Exception;
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
}
