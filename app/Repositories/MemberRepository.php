<?php
namespace App\Repositories;

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
}