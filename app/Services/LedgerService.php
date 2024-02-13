<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Member;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Services\EquipmentService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Mime\Message;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\LedgerRepository;
use App\Repositories\MemberRepository;
use App\Repositories\EquipmentRepository;

class LedgerService
{
    public function __construct(LedgerRepository $ledgerRepository)
    {       
        $this->ledgerRepository = $ledgerRepository;
    }

    public function all()
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $user_id=$user->id;
            return $this->ledgerRepository->getAll()->where('gym_id',$user_id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(Message::Failed);
        }
    }

}