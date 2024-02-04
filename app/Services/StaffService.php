<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\StaffRepository;
use App\Repositories\MemberRepository;

class StaffService
{
    public function __construct(StaffRepository $staffRepository,UserRepository $userRepository)
    {
        $this->staffRepository = $staffRepository;
        $this->userRepository = $userRepository;
    }

    public function all()
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $user_id=$user->id;
            // dd("Here");
            return $this->staffRepository->getAll()->where('gym_id',$user_id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(Message::Failed);
        }
    }

    
}
