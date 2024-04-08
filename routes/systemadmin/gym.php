<?php

use Illuminate\Support\Facades\Route;




Route::get('/gym',[GymController::class,'index'])->name('gym.index');
