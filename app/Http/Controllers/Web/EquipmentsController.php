<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\MemberService;
use App\Services\EquipmentService;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\MemberRepository;
use App\Repositories\EquipmentRepository;

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
        // dd("Here");
        try{
            // dd("Here");
            $equipment=$this->equipmentService->all();
            return view('admin.equipments.index',compact('equipment'));
        }
        catch(Exception $e){


        }


    }

}
