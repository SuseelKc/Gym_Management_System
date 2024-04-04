<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\PricingService;
use App\Http\Controllers\Controller;
use App\Repositories\MemberRepository;
use App\Repositories\EquipmentRepository;

class ReportController extends Controller
{
    //      
    public function __construct(PricingService $pricingService,MemberRepository $memberRepository,EquipmentRepository $equipmentRepository){
        $this->pricingService =$pricingService;
        $this->memberRepository=$memberRepository;
        $this->equipmentRepository=$equipmentRepository;
    }

    public function index(){
    //members indicators 
    $totalMembers= $this->memberRepository->countMembers();
    $latestTotalMembers=$this->memberRepository->latestcountMembers();
    $previousTotalMembers=$this->memberRepository->previouscountMembers();

    // calculating percentage change for previous memeber and latest mths members
    if ($previousTotalMembers != 0) {
        $percentageChange = (($latestTotalMembers - $previousTotalMembers) / $previousTotalMembers) * 100;
    } else {
        // Handling division by zero
        $percentageChange = 0;
    }

    //  
    // Equipment indicators
    $totalEquipments=$this->equipmentRepository->countEquipments();
    $latestTotalEquipments=$this->equipmentRepository->latestCountEquipments();
    $previousTotalEquipments=$this->equipmentRepository->previousCountEquipments();
   
    // 
     return view('admin.report.index',compact('totalMembers','latestTotalMembers','previousTotalMembers','percentageChange','totalEquipments','latestTotalEquipments','previousTotalEquipments'));
    }
}
