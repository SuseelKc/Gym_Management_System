<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\MemberController;



Route::get('/members',[MemberController::class,'index'])->name('member.index');
Route::get('/members/add',[MemberController::class,'create'])->name('member.create');
Route::post('/members/store',[MemberController::class,'store'])->name('member.store');
Route::get('/members/edit/{id}',[MemberController::class,'edit'])->name('member.edit');
Route::patch('/members/update/{id}',[MemberController::class,'update'])->name('member.update');
Route::get('/members/{id}',[MemberController::class,'delete'])->name('member.delete');
Route::get('/members/toggle/{id}',[MemberController::class,'toggle'])->name('member.toggle');
Route::get('/renew-membership',[MemberController::class,'renwewmembership'])->name('member.renewal');
Route::patch('/createaccount/member/{id}',[MemberController::class,'createAccount'])->name('member.create.account');

// server side data fetching
Route::post('/allmembers',[MemberController::class,'listMember'])->name('member.list');
Route::get('/member/create', [MemberController::class, 'displayCreateModal'])->name('member.displayCreateModal');
Route::post('/members/save',[MemberController::class,'saveMember'])->name('member.save');
Route::get('/members/{id}/edit', [MemberController::class, 'getDataForMemberEdit'])->name('member.getDataForEdit');
Route::post('/members/update', [MemberController::class, 'updateMember'])->name('member.updateMember');