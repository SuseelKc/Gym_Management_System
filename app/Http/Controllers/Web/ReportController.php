<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\PricingService;
use App\Http\Controllers\Controller;
use App\Repositories\MemberRepository;

class ReportController extends Controller
{
    //      
    public function __construct(PricingService $pricingService,MemberRepository $memberRepository){
        $this->pricingService =$pricingService;
        $this->memberRepository=$memberRepository;
    }

    public function index(){
    //
    $totalMembers= $this->memberRepository->countMembers();
    $latestTotalMembers=$this->memberRepository->latestcountMembers();
    $previousTotalMembers=$this->memberRepository->previouscountMembers();

    if ($previousTotalMembers != 0) {
        $percentageChange = (($latestTotalMembers - $previousTotalMembers) / $previousTotalMembers) * 100;
    } else {
        // Handling division by zero
        $percentageChange = 0;
    }

    //  
     return view('admin.report.index',compact('totalMembers','latestTotalMembers','previousTotalMembers','percentageChange'));
    }
}
