<?php

namespace App\Http\Controllers\Web;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\MemberService;
use App\Charts\MonthlySalesChart;
use Illuminate\Support\Facades\DB;
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
            
            $members = DB::select('SELECT * FROM members');


            return view('admin.dashboard.index',compact('latestRecords','topTransactions','chart','expiredMemberships','data','comingMainteneceDate','members'));
        }
        catch(Exception $e){

        }

    }


 public function fetchMemberDetails(Request $request)
{     
    try {
   
        $memberId = $request->input('member_id');
  
        $member = Member::find($memberId);
      
        if (!$member) {
            return response()->json(['error' => 'Member not found.'], 404);
        }

        // return view('members.partials.details', compact('member'));

        // Prepare the HTML content
        $html = '
            <p><strong>Name:</strong> ' . $member->name . '</p>
            <p><strong>Serial Number:</strong> ' . $member->serial_no . '</p>
            <p><strong>Email:</strong> ' . $member->email . '</p>
            <p><strong>Phone:</strong> ' . $member->phone . '</p>
            <!-- Add more fields as needed -->
        ';

        // Return the HTML content
        return response($html);
        
    } catch(Exception $e) {
        // Handle exceptions
        return response()->json(['error' => 'An error occurred.'], 500);
    }
}

}
