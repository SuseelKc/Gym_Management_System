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
    public function getWhere()
    {
        return Member::where($query);
    }
}