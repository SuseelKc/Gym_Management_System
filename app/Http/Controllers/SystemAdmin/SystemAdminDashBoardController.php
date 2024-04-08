<?php

namespace App\Http\Controllers\SystemAdmin;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SystemAdminDashBoardController extends Controller
{
    //
    public function __construct()
    {
       
      
    }

    public function index(){
        try{
            
            return view('systemadmin.dashboard.index');
        }
        catch(Exception $e){


        }
    }

}
