<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\EquipmentService;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\MemberRepository;

class EquipmentService
{
    public function __construct(EquipmentService $equipmentService,EquipmentRepository $equipmentRepository)
    {
        $this->equipmentService = $equipmentService;
        $this->equipmentRepository = $equipmentRepository;
    }

    public function all()
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $user_id=$user->id;
            return $this->equipmentRepository->getAll()->where('gym_id',$user_id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(Message::Failed);
        }
    }

    
}
