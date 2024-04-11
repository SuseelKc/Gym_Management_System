<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GymMember\AccountController;




Route::get('/account',[AccountController::class,'index'])->name('account');
// Route::get('/membersgym/delete/{id}',[GymMemberController::class,'delete'])->name('membersgym.delete');
// Route::get('/membersgym/edit/{id}',[GymMemberController::class,'edit'])->name('membersgym.edit');
// Route::patch('/membersgym/update/{id}',[GymMemberController::class,'update'])->name('membersgym.update');
