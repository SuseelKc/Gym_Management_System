<?php
namespace App\Repositories;

use App\Models\Pricing;

class PricingRepository
{
    public function getAll()
    {
        return Pricing::all();
    }
    public function getById($id)
    {
        return Pricing::find($id);
    }
    public function getWhere()
    {
        return Pricing::where($query);
    }

    // query that fetches all the pricing with mmebers count 
    public function allWithCountMembers(){
        return Pricing::withCount('members')->where('gym_id',auth()->id())->get();

    }
    public function gymPricings($gymID){
        return Pricing::all()->where('gym_id',$gymID);

    }
}