<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Http\Request;
use App\Services\MemberService;
use App\Http\Controllers\Controller;
use App\Repositories\MemberRepository;

class MemberController extends Controller
{
    //
    public function __construct(MemberService $memberService,MemberRepository $memberRepository)
    {
        $this->memberService = $memberService;
        $this->memberRepository = $memberRepository;
    }

    public function index(Request $request){
        try{
            $member=$this->memberService->all();
            return view('admin.member.index');
        }
        catch(Exception $e){

        }

    }
}
