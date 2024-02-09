<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PricingController;



Route::get('/pricing',[PricingController::class,'index'])->name('pricing.index');
Route::get('/pricing/create',[PricingController::class,'create'])->name('pricing.create');
// Route::post('/pricing/store',[PricingController::class,'store'])->name('pricing.store');
// Route::get('/pricing/edit/{id}',[PricingController::class,'edit'])->name('pricing.edit');
// Route::patch('/pricing/update/{id}',[PricingController::class,'update'])->name('pricing.update');
// Route::get('/pricing/{id}',[PricingController::class,'delete'])->name('pricing.delete');