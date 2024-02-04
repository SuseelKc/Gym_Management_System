<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\StaffController;




Route::get('/staffs',[StaffController::class,'index'])->name('staffs.index');
Route::get('/staffs/add',[StaffController::class,'create'])->name('staffs.create');
Route::post('/staffs/store',[StaffController::class,'store'])->name('staffs.store');
Route::get('/staffs/edit/{id}',[StaffController::class,'edit'])->name('staffs.edit');
Route::patch('/staffs/update/{id}',[StaffController::class,'update'])->name('staffs.update');
Route::get('/staffs/{id}',[StaffController::class,'delete'])->name('staffs.delete');
