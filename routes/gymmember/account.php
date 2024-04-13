<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GymMember\AccountController;




Route::get('/account',[AccountController::class,'index'])->name('account');
Route::post('/khalti/verify',[AccountController::class,'verify'])->name('ajax.khalti.verify_order');

Route::post('/khalti/payment/store',[AccountController::class,'storePayment'])->name('khalti.storePayment');
// Route::get('/membersgym/edit/{id}',[GymMemberController::class,'edit'])->name('membersgym.edit');
// Route::patch('/membersgym/update/{id}',[GymMemberController::class,'update'])->name('membersgym.update');
