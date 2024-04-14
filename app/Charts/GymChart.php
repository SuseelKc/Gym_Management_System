<?php

namespace App\Charts;

use App\Models\User;
use App\Models\Ledger;
use Illuminate\Support\Facades\DB;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class GymChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        
        $gymJoinedMth = User::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
        ->where('UserRole',1 )
        ->whereNotNull('created_at') // Filter out records where created_at is null
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();
    
        // Debugging: Check if $gymJoinedMth contains data
        // dd($gymJoinedMth->toArray());
        $gymJoinedPerMth = $gymJoinedMth->pluck('count')->toArray();
        $monthNames = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];
    
        // Map the numeric month values to their corresponding names
        $Months = $gymJoinedMth->pluck('month')->map(function ($month) use ($monthNames) {
            return $monthNames[$month];
        })->toArray();
        
        // Debugging: Check the $Months variable
        // dd($Months);
    
        parent::__construct();
    
        $this->labels($Months); 
        $this->dataset('Gym Join Counts Per Month', 'line', $gymJoinedPerMth)
            ->color("rgb(255, 99, 132)")
            ->backgroundColor("rgb(255, 99, 132)");
    }
    
    

}
