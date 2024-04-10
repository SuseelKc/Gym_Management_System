<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GymMember\MemberProfileController;


Route::get('/memberprofile', [MemberProfileController::class, 'index'])->name('memberprofile');
// Route::get('/membersgym/delete/{id}',[MemberProfileController::class,'delete'])->name('membersgym.delete');
// Route::get('/membersgym/edit/{id}',[MemberProfileController::class,'edit'])->name('membersgym.edit');
// Route::patch('/membersgym/update/{id}',[MemberProfileController::class,'update'])->name('membersgym.update');
