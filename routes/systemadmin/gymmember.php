<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SystemAdmin\GymMemberController;



Route::get('/membersgym',[GymMemberController::class,'index'])->name('membersgym.index');
Route::get('/membersgym/delete/{id}',[GymMemberController::class,'delete'])->name('membersgym.delete');
Route::get('/membersgym/edit/{id}',[GymMemberController::class,'edit'])->name('membersgym.edit');
Route::patch('/membersgym/update/{id}',[GymMemberController::class,'update'])->name('membersgym.update');
