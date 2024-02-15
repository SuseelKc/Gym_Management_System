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
use App\Repositories\PricingRepository;
use App\Repositories\EquipmentRepository;

class LedgerService
{
    public function __construct(LedgerRepository $ledgerRepository,PricingRepository $pricingRepository)
    {       
        $this->ledgerRepository = $ledgerRepository;
        $this->pricingRepository = $pricingRepository;
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


    public function search($id){
        try{
            DB::beginTransaction();
            $user = auth()->user();
            $user_id=$user->id;
            $ledger= $this->ledgerRepository->getById($id);
            DB::commit();
            return $ledger;
        }
        catch(Exception $e){
            DB::rollBack();
            throw new Exception(Message::Failed);
        }


    }
    public function add(Ledger $ledger, Request $request,$id)
    {
        try{
            DB::beginTransaction();
            $user = auth()->user();
            $ledger->date= Carbon::now();
            
            $pricing=$this->pricingRepository->getById($id);
            $ledger->debit=$pricing->costs;
            $ledger->balance=$pricing->costs;

            

            




            DB::commit();
            return $ledger;
        }
        catch(Exception $e){
            DB::rollBack();
            throw new Exception(Message::Failed);
        }

    }
}