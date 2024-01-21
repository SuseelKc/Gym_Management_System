<?php

namespace App\Http\Controllers\Web;

use App\Services\EquipmentService;
use App\Repositories\EquipmentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class EquipmentsController extends Controller
{
    //

    public function __construct(EquipmentService $equipmentService,EquipmentRepository $equipmentRepository,UserRepository $userRepository){
        $this->equipmentService = $equipmentService;
        $this->equipmentRepository = $equipmentRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request){
        try{
            dd("Here");
            $equipment=$this->equipmentService->all();
            return view('admin.equipments.index',compact('equipment'));
        }
        catch(Exception $e){


        }


    }

}
