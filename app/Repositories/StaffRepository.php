<?php
namespace App\Repositories;


use App\Models\Staff;

class StaffRepository
{
    public function getAll()
    {
        return Staff::all();
    }
    public function getById($id)
    {
        return Staff::find($id);
    }
    public function getWhere()
    {
        return Staff::where($query);
    }
    public function gymStaff($gymId){
        return Staff::all()->where('gym_id',$gymId);
    }
}