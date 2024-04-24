<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\MemberService;
use App\Charts\MonthlySalesChart;
use App\Http\Controllers\Controller;
use App\Repositories\LedgerRepository;
use App\Repositories\EquipmentRepository;


class DashboardController extends Controller
{
    //
    public function __construct(LedgerRepository $ledgerRepository,MemberService $memberService,EquipmentRepository $equipmentRepository)
    {
       
        $this->ledgerRepository = $ledgerRepository;
        $this->memberService= $memberService;
        $this->equipmentRepository=$equipmentRepository;
    }

    
    public function index(){     
        try{
            // for knowing remaining balance of the member query     
            $remainingLedger = $this->ledgerRepository->getMemberLedger()->groupBy('member_id');
            // Extract the latest created_at timestamp for each group
            $latestRecords = $remainingLedger->map(function ($group) {
                $latestTimestamp = $group->max('created_at');
                return $group->firstWhere('created_at', $latestTimestamp);
            });
            // 

            // for getting top 10 recent transaction 
                $topTransactions= $this->ledgerRepository->getTopTransactions();
                // ->sortByDesc('created_at');
                
            // 
            
            // monthly sales chart
            $chart = new MonthlySalesChart;
            // 

            // display expired membership names
            $expiredMemberships=$this->memberService->all()->whereNull('pricing_id');
            $totalMemberships=$this->memberService->all();
          

            // pie chart
            $data = [
                'labels' => ['Total Member', 'Expired Member'],
                'data' => [
                    $totalMemberships->count(),
                    $expiredMemberships->count()
                ]
            ];
            // 

            // upcoming maintenence date
            $comingMainteneceDate= $this->equipmentRepository->upcomingEquipmentMaintenenceDate();
            // 
            //
            
            return view('admin.dashboard.index',compact('latestRecords','topTransactions','chart','expiredMemberships','data','comingMainteneceDate'));
        }
        catch(Exception $e){

        }

    }
}
