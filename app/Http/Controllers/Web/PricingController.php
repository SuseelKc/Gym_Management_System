<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\User;
use App\Models\Pricing;
use Illuminate\Http\Request;
use App\Services\PricingService;
use App\Http\Controllers\Controller;
use App\Repositories\MemberRepository;
use App\Repositories\PricingRepository;

class PricingController extends Controller
{
    public function __construct(PricingService $pricingService,MemberRepository $memberRepository,PricingRepository $pricingRepository){
        $this->pricingService =$pricingService;
        $this->memberRepository=$memberRepository;
        $this->pricingRepository=$pricingRepository;
    }

    public function index(){
        try{

            $pricing=$this->pricingRepository->allWithCountMembers();        
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

    public function store(Request $request){
        try{
           $pricing= new Pricing();        
           $pricing=  $this->pricingService->add($pricing,$request);
           toast('Gym Package Added Successfully!','success');
           return redirect()->intended(route('pricing.index'));          
        }
        catch(Exception $e){
        }
    }

    public function edit($id){
        try{            
            $pricing=Pricing::FindOrFail($id);
            $gym_id=auth()->id();
            $gym=User::FindOrFail($gym_id);
            return view('admin.pricing.edit',compact('pricing','gym'));          
        }
        catch(Exception $e){

        }
    }

    public function update(Request $request,$id){
        try{            
            $pricing=Pricing::FindOrFail($id);
            $pricing=$this->pricingService->update($pricing,$id,$request);
            toast('Gym Package Updated Successfully!','success');
            return redirect()->intended(route('pricing.index'));    
        }
        catch(Exception $e){

        }
    }

    public function delete($id){
        try{
            $pricing=Pricing::FindOrFail($id);
            $pricing=$this->pricingService->delete($id);
            toast('Gym Package Deleted Successfully!','success');
            return redirect()->intended(route('pricing.index'));

        }
        catch(Exception $e){
            toast('Cannnot be performed! ','error');
            return redirect()->back();
        }

    }

}
