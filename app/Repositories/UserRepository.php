<?php
namespace App\Repositories;

use App\Models\User;
use App\Enums\UserRole;

class UserRepository
{
    public function getAll()
    {
        return User::all();
    }
    public function getById($id)
    {
        return User::find($id);
    }
    public function getWhere()
    {
        return User::where($query);
    }
    public function getGymAdmin(){
        return User::all()->where('UserRole',UserRole::GymAdmin);
    }

    public function getGymMember($gymMemberId){
        return User::where('member_id', $gymMemberId)->get();
    }
}