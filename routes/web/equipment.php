<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\EquipmentsController;



Route::get('/equipments',[EquipmentsController::class,'index'])->name('equipments.index');
Route::get('/equipment/add',[EquipmentsController::class,'create'])->name('equipments.create');
Route::post('/equipment/store',[EquipmentsController::class,'store'])->name('equipments.store');