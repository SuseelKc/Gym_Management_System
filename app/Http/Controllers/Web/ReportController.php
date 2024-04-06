<?php

namespace App\Http\Controllers\Web;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\LedgerService;
use App\Services\PricingService;
use App\Services\ExpensesService;
use App\Http\Controllers\Controller;
use App\Repositories\LedgerRepository;
use App\Repositories\MemberRepository;
use App\Repositories\ExpensesRepository;
use App\Repositories\EquipmentRepository;

class ReportController extends Controller
{
    //      
    public function __construct(PricingService $pricingService,MemberRepository $memberRepository,EquipmentRepository $equipmentRepository,LedgerService $ledgerService,
    LedgerRepository $ledgerRepository,ExpensesService $expensesService,ExpensesRepository $expensesRepository){
        $this->pricingService =$pricingService;
        $this->memberRepository=$memberRepository;
        $this->equipmentRepository=$equipmentRepository;
        $this->ledgerService=$ledgerService;
        $this->ledgerRepository= $ledgerRepository;
        $this->expensesService=$expensesService;
        $this->expensesRepository=$expensesRepository;
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

    //Overall
    $totalRevenue=$this->ledgerService->all()->whereNotNull('credit')->sum('credit');  
    $expenses=$this->expensesService->all();
    $totalExpenses=$this->expensesService->all()->sum('costs');
    $NetIncome=$totalRevenue - $totalExpenses;   
    // 

    // this month 
    $totalRevenueMth=$this->ledgerRepository->latestMonthCreditSum();  // this month revenue income 
    $expensesMth=$this->expensesService->all()
    ->whereBetween('start_date',[Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]); // this month expenses 
    $totalExpensesMth=$this->expensesRepository->latestMonthExpensesSum(); // this month expenses total
    $NetIncomeMth=$totalRevenueMth - $totalExpensesMth; 
  
    //this year
    $totalRevenueYear=$this->ledgerRepository->latestYearCreditSum();  // this month revenue income   
    $expensesYear=$this->expensesService->all()
    ->whereBetween('start_date',[Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]); // this month expenses 
    $totalExpensesYear=$this->expensesRepository->latestYearExpensesSum(); // this month expenses total
    $NetIncomeYear=$totalRevenueYear - $totalExpensesYear;  
    // dd($NetIncomeYear);
    // 

     return view('admin.report.index',compact('totalMembers','latestTotalMembers','previousTotalMembers','totalEquipments','latestTotalEquipments','previousTotalEquipments'
    ,'totalDebit','totalCredit','AcReceivableChange','totalRevenue','expenses','totalExpenses','NetIncome',
    'totalRevenueMth','expensesMth','totalExpensesMth','NetIncomeMth',
    'totalRevenueYear','expensesYear','totalExpensesYear','NetIncomeYear'));
    }
}
