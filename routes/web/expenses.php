<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ExpensesController;



Route::get('/expenses',[ExpensesController::class,'index'])->name('expenses.index');
// Route::get('/expenses/add',[ExpensesController::class,'create'])->name('expenses.create');
// Route::post('/expenses/store',[ExpensesController::class,'store'])->name('expenses.store');
// Route::get('/expenses/edit/{id}',[ExpensesController::class,'edit'])->name('expenses.edit');
// Route::patch('/expenses/update/{id}',[ExpensesController::class,'update'])->name('expenses.update');
// Route::get('/expenses/{id}',[ExpensesController::class,'delete'])->name('expenses.delete');