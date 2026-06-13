<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAdController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminMakeController;
use Illuminate\Support\Facades\Route;

// ==========================================
// PUBLIC ROUTES
// ==========================================
Route::get('/',            [HomeController::class, 'index'])->name('home');
Route::get('/search',      [AdController::class,   'search'])->name('ads.search');
Route::get('/ad/{id}',     [AdController::class,   'show'])->name('ads.show');

// ==========================================
// AUTH ROUTES
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('/login',          [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login',         [AuthController::class, 'login']);
    Route::get('/register',       [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register',      [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================
// AUTHENTICATED USER ROUTES
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/post-ad',        [AdController::class, 'create'])->name('ads.create');
    Route::post('/post-ad',       [AdController::class, 'store'])->name('ads.store');
    Route::get('/my-ads',         [UserController::class, 'myAds'])->name('user.my-ads');
    Route::get('/my-ads/{id}/sold',   [UserController::class, 'markSold'])->name('user.sold');
    Route::delete('/my-ads/{id}', [UserController::class, 'deleteAd'])->name('user.delete-ad');
    Route::get('/favorites',      [FavoriteController::class, 'index'])->name('favorites');
    Route::post('/favorite/{id}', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
});

// ==========================================
// ADMIN ROUTES
// ==========================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',               [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/ads',            [AdminAdController::class, 'index'])->name('ads');
    Route::get('/ads/{id}/approve',  [AdminAdController::class, 'approve'])->name('ads.approve');
    Route::get('/ads/{id}/reject',   [AdminAdController::class, 'reject'])->name('ads.reject');
    Route::get('/ads/{id}/feature',  [AdminAdController::class, 'feature'])->name('ads.feature');
    Route::delete('/ads/{id}',    [AdminAdController::class, 'destroy'])->name('ads.delete');
    Route::get('/users',          [AdminUserController::class, 'index'])->name('users');
    Route::get('/makes',          [AdminMakeController::class, 'index'])->name('makes');
    Route::post('/makes',         [AdminMakeController::class, 'store'])->name('makes.store');
    Route::delete('/makes/{id}',  [AdminMakeController::class, 'destroy'])->name('makes.delete');
});
