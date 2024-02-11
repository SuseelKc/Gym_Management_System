<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\LedgerController;



Route::get('/ledger',[LedgerController::class,'index'])->name('ledger.index');