<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GymMember\MemberProfileController;


Route::get('/memberprofile', [MemberProfileController::class, 'index'])->name('memberprofile');
Route::patch('/memberprofile/update/{id}',[MemberProfileController::class,'update'])->name('memberprofile.update');
Route::get('/memberprofile/edit/{id}',[MemberProfileController::class,'edit'])->name('memberprofile.edit');

