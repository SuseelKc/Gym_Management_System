<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\LedgerRepository;

class DashboardController extends Controller
{
    //
    public function __construct(LedgerRepository $ledgerRepository)
    {
       
        $this->ledgerRepository = $ledgerRepository;
        
    }


    public function index(){     
        try{       
            $remainingLedger = $this->ledgerRepository->getMemberLedger()->groupBy('member_id');
            // Extract the latest created_at timestamp for each group
            $latestRecords = $remainingLedger->map(function ($group) {
                $latestTimestamp = $group->max('created_at');
                return $group->firstWhere('created_at', $latestTimestamp);
            });
    
            // dd($latestRecords);
            return view('admin.dashboard.index',compact('latestRecords'));
        }
        catch(Exception $e){

        }

    }
}
