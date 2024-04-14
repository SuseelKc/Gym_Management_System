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
   
    public function previousCountEquipments(){
        $programInceptionDate = Carbon::create(1900, 1, 1); // January 1, 1900
        $previousMonthStart = $programInceptionDate->startOfMonth();
        $previousMonthEnd= Carbon::now()->subMonth()->endOfMonth();
        
        return Equipment::where('gym_id',auth()->id())
        ->whereBetween('created_at',[$previousMonthStart,$previousMonthEnd])
        ->count();
    }

    public function gymEquipment($gymId){
        return Equipment::all()->where('gym_id',$gymId);
    }

    public function upcomingEquipmentMaintenenceDate(){

        $currentDate = Carbon::now();

        // Calculate one month from the current date upcoming date
        $oneMonthLater = $currentDate->copy()->addMonth();

         // Retrieve equipment with upcoming maintenance within one month and sort by upcoming_date
        return Equipment::where('gym_id',auth()->id())->whereBetween('upcoming_date', [$currentDate, $oneMonthLater])
        ->orderBy('upcoming_date')
        ->get();
        
        

    }

}