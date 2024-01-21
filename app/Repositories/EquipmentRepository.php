<?php
namespace App\Repositories;

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
}