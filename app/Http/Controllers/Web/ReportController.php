<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\LedgerService;
use App\Services\PricingService;
use App\Http\Controllers\Controller;
use App\Repositories\LedgerRepository;
use App\Repositories\MemberRepository;
use App\Repositories\EquipmentRepository;

class ReportController extends Controller
{
    //      
    public function __construct(PricingService $pricingService,MemberRepository $memberRepository,EquipmentRepository $equipmentRepository,LedgerService $ledgerService,
    LedgerRepository $ledgerRepository){
        $this->pricingService =$pricingService;
        $this->memberRepository=$memberRepository;
        $this->equipmentRepository=$equipmentRepository;
        $this->ledgerService=$ledgerService;
        $this->ledgerRepository= $ledgerRepository;
    }

    public function index(){
    //members indicators 
    $totalMembers= $this->memberRepository->countMembers();
    $latestTotalMembers=$this->memberRepository->countMembers();
    $previousTotalMembers=$this->memberRepository->previouscountMembers();

    //  
    // Equipment indicators
    $totalEquipments=$this->equipmentRepository->countEquipments();
    $latestTotalEquipments=$this->equipmentRepository->countEquipments();
    $previousTotalEquipments=$this->equipmentRepository->previousCountEquipments();
   
    // account receivables calculations
    $totalDebit = $this->ledgerService->all()->whereNotNull('debit')->sum('debit');
    $totalCredit = $this->ledgerService->all()->whereNotNull('credit')->sum('credit');

    $previousDebit = $this->ledgerRepository->previousDebitMonths(); 
    $previousCredit = $this->ledgerRepository->previousCreditMonths();
    
    // calculating previous and latest mths ac recivable
    $totalAcReceivable=$totalDebit-$totalCredit; //positive or negative receivable balance
    $previousAcReceivable=$previousDebit-$previousCredit; //positive or negative receivable balance
    // dd($totalAcReceivable);

    $AcReceivableChange=(($totalAcReceivable - $previousAcReceivable) / $previousAcReceivable)*100;
    $AcReceivableChange = round($AcReceivableChange, 2); 

    // 
     return view('admin.report.index',compact('totalMembers','latestTotalMembers','previousTotalMembers','totalEquipments','latestTotalEquipments','previousTotalEquipments'
    ,'totalDebit','totalCredit','AcReceivableChange'));
    }
}
