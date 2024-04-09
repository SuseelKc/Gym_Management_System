<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SystemAdmin\GymController;


Route::get('/gym',[GymController::class,'index'])->name('gym.index');
Route::get('/gym/delete/{id}',[GymController::class,'delete'])->name('gym.delete');
