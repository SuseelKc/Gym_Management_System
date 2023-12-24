<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    //
    public function __construct(MemberService $memberService,MemberRepository $memberRepository)
    {
        $this->memberService = $memberService;
        $this->memberRepository = $memberRepository;
    }

    public function index(Request $request){

    }
}
