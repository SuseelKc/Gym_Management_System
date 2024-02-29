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
            // 
            
            return view('admin.dashboard.index',compact('latestRecords','topTransactions'));
        }
        catch(Exception $e){

        }

    }
}
