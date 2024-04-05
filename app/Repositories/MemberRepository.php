<?php
namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Member;

class MemberRepository
{
    public function getAll()
    {
        return Member::all();
    }
    public function getById($id)
    {
        return Member::find($id);
    }
    public function getWhere($query)
    {
        return Member::where($query);
    }
    public function groupByPricing($id){
        return Member::where('pricing_id',$id)
        ->where('user_id',auth()->id())
        ->count();
    }
    public function countMembers(){
        return Member::where('user_id',auth()->id())->count();
    }

    // public function latestCountMembers()
    // {
    //     $currentMonthStart = Carbon::now()->startOfMonth();
    //     $currentMonthEnd = Carbon::now()->endOfMonth();
        
    //     return Member::where('user_id', auth()->id())
    //                  ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
    //                  ->count();
    // }
    
    public function previousCountMembers()
    {
        $programInceptionDate = Carbon::create(1900, 1, 1); // January 1, 1900
        $previousMonthStart = $programInceptionDate->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        return Member::where('user_id', auth()->id())
                    ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
                    ->count();
    }
}