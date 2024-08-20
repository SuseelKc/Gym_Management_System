<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\EquipmentsController;



Route::get('/equipments',[EquipmentsController::class,'index'])->name('equipments.index');
Route::get('/equipments/add',[EquipmentsController::class,'create'])->name('equipments.create');
Route::post('/equipments/store',[EquipmentsController::class,'store'])->name('equipments.store');
Route::get('/equipments/edit/{id}',[EquipmentsController::class,'edit'])->name('equipments.edit');
Route::patch('/equipments/update/{id}',[EquipmentsController::class,'update'])->name('equipments.update');
Route::get('/equipments/{id}',[EquipmentsController::class,'delete'])->name('equipments.delete');

Route::post('/fetchEquipments',[EquipmentsController::class,'fetchEquipments'])->name('fetchEquipments');//fetch equipments to its table
Route::post('/equipment/save',[EquipmentsController::class,'saveEquipment'])->name('equipments.save');//save equipments from modal
Route::get('/equipment/{id}/edit',[EquipmentsController::class,'editEquipment'])->name('equipment.edit');
Route::post('/equipment/update', [EquipmentsController::class, 'updateEquipment'])->name('equipment.update');
Route::get('/deleteEquipment/{id}',[EquipmentsController::class,'deleteEquipment'])->name('equipment.delete');