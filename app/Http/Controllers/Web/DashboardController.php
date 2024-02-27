<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){     
        try{       
            // $equipment=$this->equipmentService->all();
            // dd("Here");
            return view('admin.dashboard.index');
        }
        catch(Exception $e){

        }

    }
}
