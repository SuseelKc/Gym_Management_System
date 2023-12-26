<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\MemberController;



Route::get('/members',[MemberController::class,'index'])->name('member.index');
Route::get('/member/add',[MemberController::class,'create'])->name('member.create');