<?php

namespace App\Services;

use Exception;
use App\Models\Member;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;


class UserService
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function all()
    {
        try {
            DB::beginTransaction();
            return $this->userRepository->getAll();
            DB::commit();
        } catch (Exception $e) {
            // DB::rollBack();
            // throw new Exception(Message::Failed);
        }
    }

  




    
    
}
