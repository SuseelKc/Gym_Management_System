<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\MemberController;



Route::get('/members',[MemberController::class,'index'])->name('member.index');
Route::get('/members/add',[MemberController::class,'create'])->name('member.create');
Route::post('/members/store',[MemberController::class,'store'])->name('member.store');
Route::get('/members/edit/{id}',[MemberController::class,'edit'])->name('member.edit');
Route::patch('/members/update/{id}',[MemberController::class,'update'])->name('member.update');
Route::get('/members/{id}',[MemberController::class,'delete'])->name('member.delete');