<?php

namespace App\Http\Controllers\Web;

use App\Models\Member;
use App\Models\PackageAdmissionLog;
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
        try 
        {
            $memberId = $request->input('member_id');
    
            $member = Member::find($memberId);
        
            if (!$member) 
            {
                return response()->json(['error' => 'Member not found.'], 404);
            }

            $packageLogs = PackageAdmissionLog::where('member_id', $memberId)
                        ->orderBy('created_at', 'desc')  
                        ->get();

            $photoUrl = $member->photo == null 
            ? asset('/images/defaultimage.jpg') 
            : asset('/images/members/'.$member->photo);


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
            ';

            if ($packageLogs->isNotEmpty()) 
            {
                $html .= '<div class="mb-2">
                    <h6 class="text-primary"><strong>Package History</strong></h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Package Name</th>
                                <th>Duration</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Added On</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>';
            
                // Variable to track if admission charge should be displayed separately
                $admissionCharge = null;
            
                foreach ($packageLogs as $log) 
                {
                    // Fetch package details from the pricing table
                    $pricing = \App\Models\Pricing::find($log->package_id);
            
                    // Format package name, price, and duration
                    $packageName = $pricing ? $pricing->name : 'N/A';
                    $price = $pricing ? $pricing->costs : 'N/A';
                    $duration = $pricing ? $pricing->duration . " " . $pricing->costs_type : 'N/A';
            
                    // If the log has an admission price, exclude it from the package history
                    if ($log->admission_price) 
                    {
                        // Store the admission charge to display later
                        $admissionCharge = $log->admission_price;
                    } 
                    else 
                    {
                        // Format the created_at date to only show the date
                        $addedOn = date('Y-m-d', strtotime($log->created_at));
            
                        // Build the table row with package details
                        $html .= '
                        <tr>
                            <td>' . $packageName . '</td>
                            <td>' . $duration . '</td>
                            <td>' . $log->start_date . '</td>
                            <td>' . $log->end_date . '</td>
                            <td>' . $addedOn . '</td>
                            <td>' . $price . '</td>
                        </tr>';
                    }
                }
            
                $html .= '</tbody></table></div>';
            
                // If an admission charge exists, display it separately
                if ($admissionCharge) {
                    $html .= 
                    '<div class="mb-2">
                        <h6 class="text-primary"><strong>Admission Charge</strong></h6>
                        <p><i class="fas fa-money-bill"></i> Price: ' . $admissionCharge . '</p>
                    </div>';
                }
            } 
            else 
            {
                $html .= '<p>No package history available.</p>';
            }

            return response($html);

        } 
        catch(Exception $e) 
        {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

}
