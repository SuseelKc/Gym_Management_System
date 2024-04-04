<?php
namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Equipment;
use App\Repositories\EquipmentRepository;

class EquipmentRepository
{
    public function getAll()
    {
        return Equipment::all();
    }
    public function getById($id)
    {
        return Equipment::find($id);
    }
    public function getWhere($query)
    {
        return Equipment::where($query);
    }
    public function countEquipments(){
        return Equipment::where('gym_id',auth()->id())->count();
    }
    public function latestCountEquipments(){
        $currentMonthStart=Carbon::now()->startOfMonth();
        $currentMonthEnd= Carbon::now()->endOfMonth();
        
        return Equipment::where('gym_id',auth()->id())
        ->whereBetween('created_at',[$currentMonthStart,$currentMonthEnd])
        ->count();
    }
    public function previousCountEquipments(){
        $previousMonthStart=Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd= Carbon::now()->subMonth()->endOfMonth();
        
        return Equipment::where('gym_id',auth()->id())
        ->whereBetween('created_at',[$previousMonthStart,$previousMonthEnd])
        ->count();
    }
}