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
}