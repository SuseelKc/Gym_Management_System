<?php

namespace App\Charts;

use App\Models\Ledger;
use Illuminate\Support\Facades\DB;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class MonthlySalesChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        $sales = Ledger::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(debit) as total_debit'))
        ->where('gym_id', auth()->id())
        ->whereNotNull('debit')
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();

        // Extracting total debit values from $sales collection
        $totalDebits = $sales->pluck('total_debit')->toArray();
       // Define an array to map numeric month values to their names
        $monthNames = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        // Pluck the numeric month values and map them to their corresponding names
        $salesMonths = $sales->pluck('month')->map(function ($month) use ($monthNames) {
            return $monthNames[$month];
        })->toArray();

        // dd($salesMonths);
        parent::__construct();

        // $this->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
        $this->labels($salesMonths); 
        $this->dataset('Sales', 'line',  $totalDebits )
            ->color("rgb(255, 99, 132)")
            ->backgroundcolor("rgb(255, 99, 132)");
    }
}
