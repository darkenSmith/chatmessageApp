<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminController::class, 'index'])->name('admin.messages');
Route::post('/admin/messages/{message}/complete', [AdminController::class, 'confirmMessage']);

//Route::get('/broadcasting/auth', function () {
//    return Broadcast::auth(request());
//});

