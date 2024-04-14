<?php

namespace App\Http\Controllers\SystemAdmin;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Charts\GymChart;

class SystemAdminDashBoardController extends Controller
{
    //
    public function __construct()
    {
       
      
    }

    public function index(){
        try{
            
            $chart = new GymChart;

            return view('systemadmin.dashboard.index',compact('chart'));
        }
        catch(Exception $e){


        }
    }

}
