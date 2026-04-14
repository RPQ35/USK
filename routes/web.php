<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::resource('/',PosController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // ====================
    //    Profile
    // ===================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // ==================
        // Product
    // =================
    Route::resource('/product', ProductController::class);
    Route::POST('/product/del2',[ProductController::class,'destroy2'])->name('product.delete2');
    Route::post('/product/update2',[ProductController::class,'update2'])->name('product.update2');


    // ==================
        // Account
    // =================
    Route::resource('/account',AccountController::class);
    Route::post('/account/update2',[AccountController::class,'update2'])->name('account.update2');
    Route::post('/account/destroy2',[AccountController::class,'destroy2'])->name('account.delete2');


});

require __DIR__ . '/auth.php';


// <a
//     href="{{ route('register') }}"
//     class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
//     Register
// </a>