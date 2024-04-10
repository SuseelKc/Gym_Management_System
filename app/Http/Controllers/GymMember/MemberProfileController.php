<?php

namespace App\Http\Controllers\GymMember;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\MemberRepository;

class MemberProfileController extends Controller
{
    //
    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository=$memberRepository;
       
        
    }
    public function index(){
        try{
            dd("Hurray");
        }
        catch(Exception $e){

        }
    }

}
