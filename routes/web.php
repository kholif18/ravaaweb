<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/layanan', [FrontendController::class, 'layanan'])->name('layanan');
Route::get('/product', [FrontendController::class, 'product'])->name('product');
Route::get('/product/{slug}', [FrontendController::class, 'detailProduct'])->name('detail-product');
Route::get('/portofolio', [FrontendController::class, 'portofolio'])->name('portofolio');
Route::get('/software-house', [FrontendController::class, 'softwareHouse'])->name('software-house');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');

/*
|--------------------------------------------------------------------------
| Admin Login Routes
|--------------------------------------------------------------------------
*/
Route::get('admin/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');
