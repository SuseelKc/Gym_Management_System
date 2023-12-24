<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\MemberController;



Route::get('/member',[MemberController::class,'index'])->name('member.index');