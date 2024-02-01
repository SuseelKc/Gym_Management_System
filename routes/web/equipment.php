<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\EquipmentsController;



Route::get('/equipments',[EquipmentsController::class,'index'])->name('equipments.index');
Route::get('/equipments/add',[EquipmentsController::class,'create'])->name('equipments.create');
Route::post('/equipments/store',[EquipmentsController::class,'store'])->name('equipments.store');
Route::get('/equipments/edit/{id}',[MemberController::class,'edit'])->name('equipments.edit');