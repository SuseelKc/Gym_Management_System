<?php

use App\Enums\UserRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\SystemAdmin\SystemAdminDashBoardController;

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


// for userrole is systemadmin
Route::middleware('auth','verified', 'role:' . UserRole::SystemAdmin)->group(function () {

    Route::get('/systemadmindashboard', [SystemAdminDashBoardController::class, 'index'])->name('systemadmindashboard');

    // for systemadmin
    require __DIR__ . '/systemadmin/gym.php';
    // 
    // foreach (glob(__DIR__ . '/systemadmin/*.php') as $filename) {
    //     require $filename;
    // }
});  


// for userrole is Gymadmin
Route::middleware('auth','verified', 'role:' . UserRole::GymAdmin)->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
   
    require __DIR__ . '/web/member.php';
    require __DIR__ . '/web/user.php';
    require __DIR__ . '/web/equipment.php';
    require __DIR__ . '/web/staff.php';
    require __DIR__ . '/web/pricing.php';
    require __DIR__ . '/web/ledger.php';
    require __DIR__ . '/web/expenses.php';
    require __DIR__ . '/web/report.php';

    

    // foreach (glob(__DIR__ . '/web/*.php') as $filename) {
    //     require $filename;
    // }

});

// for all authenticated users
Route::middleware('auth','verified')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});



require __DIR__.'/auth.php';
