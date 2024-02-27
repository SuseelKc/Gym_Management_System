<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // support 
    Route::get('/support', function () {
        return view('admin.support.index');
    })->middleware(['auth', 'verified'])->name('support');
    // 


    require __DIR__ . '/web/member.php';
    require __DIR__ . '/web/user.php';
    require __DIR__ . '/web/equipment.php';
    require __DIR__ . '/web/staff.php';
    require __DIR__ . '/web/pricing.php';
    require __DIR__ . '/web/ledger.php';
    
    foreach (glob(__DIR__ . '/web/*.php') as $filename) {
        require $filename;
    }


});

require __DIR__.'/auth.php';
