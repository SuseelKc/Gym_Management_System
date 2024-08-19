<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\StaffController;




// Route::get('/staffs',[StaffController::class,'index'])->name('staffs.index');
Route::get('/staffs/add',[StaffController::class,'create'])->name('staffs.create');
Route::post('/staffs/store',[StaffController::class,'store'])->name('staffs.store');
Route::get('/staffs/edit/{id}',[StaffController::class,'edit'])->name('staffs.edit');
Route::patch('/staffs/update/{id}',[StaffController::class,'update'])->name('staffs.update');
Route::get('/staffs/{id}',[StaffController::class,'delete'])->name('staffs.delete');

Route::get('/staffs',[StaffController::class,'staffIndex'])->name('staffs.staffindex');
Route::post('/allStaff',[StaffController::class,'listStaff'])->name('staffs.list');//fetches data to the table
Route::post('/staff/save',[StaffController::class,'saveStaff'])->name('staffs.save');
Route::get('/staff/{id}/edit', [StaffController::class, 'getDataForStaffEdit'])->name('staffs.getDataForEdit');
Route::post('/staff/update', [StaffController::class, 'updateStaff'])->name('staffs.updateStaff');
Route::get('/deletestaff/{id}',[StaffController::class,'deleteStaff'])->name('staffs.deleteStaff');