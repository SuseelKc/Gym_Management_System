<?php

namespace App\Services;

use Exception;
use App\Models\Member;
use App\Repositories\MemberRepository;

class MemberService
{
    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function all()
    {
        try {
            DB::beginTransaction();
            return $this->memberRepository->getAll();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(Message::Failed);
        }
    }

  




    
    
}
