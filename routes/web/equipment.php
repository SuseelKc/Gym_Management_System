<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\EquipmentsController;



Route::get('/equipments',[EquipmentsController::class,'index'])->name('equipments.index');
