<?php

namespace App\Http\Controllers\SystemAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GymController extends Controller
{
    //
    public function __contsruct(){

    }

    public function index(){
        try{
            
            return view('systemadmin.gym.index');
        }
        catch(Exception $e){


        }
    }
}
