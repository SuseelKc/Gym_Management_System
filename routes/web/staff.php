<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\StaffController;



Route::get('/equipment',[StaffController::class,'index'])->name('staff.index');
