<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\LedgerController;



Route::get('/ledger',[LedgerController::class,'index'])->name('ledger.index');
Route::get('/ledger-search/{id}',[LedgerController::class,'search'])->name('ledger.search');
Route::post('/ledger/storepayment/{id}',[LedgerController::class,'storeMemberPayment'])->name('ledger.storepayment');

Route::post('/filterLedger',[LedgerController::class,'ledger']);
Route::post('/get-members', [LedgerController::class, 'getMembers']);