<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\User;
use App\Models\Pricing;
use Illuminate\Http\Request;
use App\Services\PricingService;
use App\Http\Controllers\Controller;

class PricingController extends Controller
{
    public function __construct(PricingService $pricingService){
        $this->pricingService =$pricingService;

    }

    public function index(){
        try{
            $pricing=$this->pricingService->all();
            return view('admin.pricing.index',compact('pricing'));
        }
        catch(Exception $e){

        }
    }

    public function create(){
        try{
         
            $gym_id=auth()->id();
            $gym=User::FindOrFail($gym_id);
            return view('admin.pricing.create',compact('gym'));
        }
        catch(Exception $e){

        }
    }

}
