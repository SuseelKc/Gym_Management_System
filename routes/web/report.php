<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ReportController;



Route::get('/report',[ReportController::class,'index'])->name('report.index');
