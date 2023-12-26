<?php

namespace App\Http\Controllers\Web;

use Exception;
use Illuminate\Http\Request;
use App\Services\MemberService;
use App\Http\Controllers\Controller;
use App\Repositories\MemberRepository;

class UserController extends Controller
{
    //
    public function __construct(UserService $userService,UserRepository $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request){
        try{
        
        }
        catch(Exception $e){

        }

    }

    
}
