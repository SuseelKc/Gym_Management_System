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

          // Prepare the HTML content
          $photoUrl = $member->photo == null 
          ? asset('/images/defaultimage.jpg') 
          : asset('/images/members/'.$member->photo);
          
          //search the balance of the member  if exist
          $checkBalance = DB::select("SELECT balance FROM ledger WHERE member_id = ? ORDER BY created_at DESC LIMIT 1", [$memberId]);

        // Check if balance exists and extract it
        $balance = !empty($checkBalance) ? $checkBalance[0]->balance : 'N/A';


        $html = '
        <div class="d-flex align-items-center mb-3">
            <div class="mr-3">
                <img src="'.$photoUrl.'" class="img-thumbnail" style="width:85px; height:95px; border-radius:10%;">
            </div>
            <div>
                <h5 class="mb-1"><strong>' . $member->name . '</strong></h5>
                <p class="text-muted mb-0">Serial Number: ' . $member->serial_no . '</p>
            </div>
        </div>
        <hr>
        <div class="mb-2">
            <h6 class="text-primary"><strong>Contact Information</strong></h6>
            <p><i class="fas fa-envelope"></i> Email: ' . $member->email . '</p>
            <p><i class="fas fa-phone"></i> Phone: ' . $member->contact_no . '</p>
        </div>
        <hr>
        <div class="mb-2">
            <h6 class="text-primary"><strong>Shift Details</strong></h6>
            <p><i class="fas fa-clock"></i> Shifts: ' . $member->shift . '</p>
        </div>
        <hr>
        <div class="mb-2">
            <h6 class="text-primary"><strong>Financial Information</strong></h6>
            <p><i class="fas fa-wallet"></i> Balance Remaining: <span class="text-success">' . $balance . '</span></p>
        </div>
        ';
        

        // Return the HTML content
        return response($html);

    } catch(Exception $e) {
        // Handle exceptions
        return response()->json(['error' => 'An error occurred.'], 500);
    }
}

}
