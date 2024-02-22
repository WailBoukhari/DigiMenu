<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantOwnerController;
use App\Http\Controllers\SubscriptionController;
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
    Route::get('/restaurant-owners', [AdminController::class, 'manageRestaurantOwners'])->name('admin.restaurant_owners.index');
    Route::get('/admin/users/create', [AdminController::class, 'createUserForm'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'createUser'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUserForm'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'editUser'])->name('admin.users.update');
    Route::post('/remove-operator-role/{id}', [AdminController::class, 'removeOperatorRole'])->name('remove.operator.role');
    Route::post('/make-operator/{user}', [AdminController::class, 'makeOperator'])->name('make.operator');
    Route::get('/restaurant_owner/dashboard', [RestaurantOwnerController::class, 'dashboard'])->name('restaurant_owner.dashboard');

    Route::get('/restaurant/menu', [RestaurantOwnerController::class, 'menuItemsIndex'])->name('restaurant.menu.index');
    Route::get('/restaurant/menu/create', [RestaurantOwnerController::class, 'menuItemsCreate'])->name('restaurant.menu.create');
    Route::post('/restaurant/menu', [RestaurantOwnerController::class, 'menuItemsStore'])->name('restaurant.menu.store');
    Route::get('/restaurant/menu/{menuItem}/edit', [RestaurantOwnerController::class, 'menuItemsEdit'])->name('restaurant.menu.edit');
    Route::put('/restaurant/menu/{menuItem}', [RestaurantOwnerController::class, 'menuItemsUpdate'])->name('restaurant.menu.update');
    Route::delete('/restaurant/menu/{menuItem}', [RestaurantOwnerController::class, 'menuItemsDestroy'])->name('restaurant.menu.destroy');

    Route::get('/restaurant_owner/menus', [RestaurantOwnerController::class, 'menuIndex'])->name('restaurant.menus.index');
    Route::get('/menus/create', [RestaurantOwnerController::class, 'menuCreate'])->name('restaurant.menus.create');
    Route::post('/menus', [RestaurantOwnerController::class, 'menuStore'])->name('restaurant.menus.store');
    Route::get('/menus/{menu}/edit', [RestaurantOwnerController::class, 'menuEdit'])->name('restaurant.menus.edit');
    Route::put('/menus/{menu}', [RestaurantOwnerController::class, 'menuUpdate'])->name('restaurant.menus.update');
    Route::delete('/menus/{menu}', [RestaurantOwnerController::class, 'menuDestroy'])->name('restaurant.menus.destroy');

    Route::get('/restaurant/profile', [RestaurantOwnerController::class, 'restaurantProfile'])->name('restaurant.profile');
    Route::get('/restaurant/profile/edit', [RestaurantOwnerController::class, 'restaurantEdit'])->name('restaurant.profile.edit');
    Route::put('/restaurant/profile/update/{id}', [RestaurantOwnerController::class, 'restaurantUpdate'])->name('restaurant.profile.update');
    Route::get('/restaurant/profile/create', [RestaurantOwnerController::class, 'restaurantCreate'])->name('restaurant.profile.create');
    Route::post('/restaurant/profile/store', [RestaurantOwnerController::class, 'restaurantStore'])->name('restaurant.profile.store');

});


// social login routes
Route::get('/auth/google', [AuthenticatedSessionController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthenticatedSessionController::class, 'handleGoogleCallback']);


//sub
Route::get('/subscribe', [SubscriptionController::class, 'showSubscriptionForm'])->name('subscription.form');
Route::post('/subscribe', [SubscriptionController::class, 'processSubscription'])->name('subscription.process');

require __DIR__.'/auth.php';
