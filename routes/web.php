<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users.index');
    Route::get('/admin/operators', [AdminController::class, 'manageOperators'])->name('admin.operators.index');
    Route::get('/admin/subscribers', [AdminController::class, 'manageSubscribers'])->name('admin.subscribers.index');
    Route::get('/admin/users/create', [AdminController::class, 'createUserForm'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'createUser'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUserForm'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'editUser'])->name('admin.users.update');
});


// social login routes
Route::get('/auth/google', [AuthenticatedSessionController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthenticatedSessionController::class, 'handleGoogleCallback']);

require __DIR__.'/auth.php';
