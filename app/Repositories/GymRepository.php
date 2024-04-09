<?php
namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;


class GymRepository
{
    public function getAll()
    {
        return User::all();
    }
    public function getById($id)
    {
        return User::find($id);
    }
    public function getWhere($query)
    {
        return User::where($query);
    }
   
}