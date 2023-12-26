<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UserController;



Route::get('/member',[UserController::class,'index'])->name('user.index');
