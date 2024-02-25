<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantOwnerController;
use App\Http\Controllers\SubscriptionController;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;









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

Route::get('/unverified', function () {
    return view('unverified');
})->name('unverified');

Route::get('/user/dashboard', function () {
    return view('user_dashboard');
})->middleware(['auth', 'verified'])->name('user.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');


    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users.index');
    Route::get('/admin/operators', [AdminController::class, 'manageOperators'])->name('admin.operators.index');
    Route::get('/admin/subscribers', [AdminController::class, 'manageSubscribers'])->name('admin.subscribers.index');

    Route::get('/admin/users/create', [AdminController::class, 'createUserForm'])->name('admin.users.create');
    Route::post('/admin/users/store', [AdminController::class, 'createUser'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUserForm'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'editUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');


    Route::post('/remove-operator-role/{id}', [AdminController::class, 'removeOperatorRole'])->name('remove.operator.role');
    Route::post('/make-operator/{user}', [AdminController::class, 'makeOperator'])->name('make.operator');

    Route::get('/admin/subscription-plans', [AdminController::class, 'indexSubscribers'])->name('admin.subscription.index');
    Route::get('/admin/subscription-plans/create', [AdminController::class, 'createSubscribers'])->name('admin.subscription.create');
    Route::post('/admin/subscription-plans', [AdminController::class, 'storeSubscribers'])->name('admin.subscription.store');
    Route::get('/admin/subscription-plans/{id}/edit', [AdminController::class, 'editSubscribers'])->name('admin.subscription.edit');
    Route::put('/admin/subscription-plans/{id}', [AdminController::class, 'updateSubscribers'])->name('admin.subscription.update');

    Route::get('/restaurant_owner/dashboard', [RestaurantOwnerController::class, 'dashboardOwner'])->name('restaurant_owner.dashboard');
    Route::get('/operator/dashboard', [RestaurantOwnerController::class, 'dashboardOperator'])->name('operator.dashboard');
    
    Route::get('/operator/menu', [RestaurantOwnerController::class, 'menuOperatorIndex'])->name('operator.menu');
    Route::get('/operator/menu_item', [RestaurantOwnerController::class, 'menuItemOperatorIndex'])->name('operator.menu_item');


    Route::get('/restaurant/menu', [RestaurantOwnerController::class, 'menuItemsIndex'])->name('restaurant.menu.index');
    Route::get('/restaurant/menu/create', [RestaurantOwnerController::class, 'menuItemsCreate'])->name('restaurant.menu.create');
    Route::post('/restaurant/menu', [RestaurantOwnerController::class, 'menuItemsStore'])->name('restaurant.menu.store');
    Route::get('/restaurant/menu/{menuItem}/edit', [RestaurantOwnerController::class, 'menuItemsEdit'])->name('restaurant.menu.edit');
    Route::put('/restaurant/menu/{menuItem}', [RestaurantOwnerController::class, 'menuItemsUpdate'])->name('restaurant.menu.update');
    Route::delete('/restaurant/menu/{menuItem}', [RestaurantOwnerController::class, 'menuItemsDestroy'])->name('restaurant.menu.destroy');

    Route::get('/restaurant_owner/menus', [RestaurantOwnerController::class, 'menuIndex'])->name('restaurant.menus.index');
    Route::get('/restaurant_owner/menus/create', [RestaurantOwnerController::class, 'menuCreate'])->name('restaurant.menus.create');
    Route::post('/restaurant_owner/menus/store', [RestaurantOwnerController::class, 'menuStore'])->name('restaurant.menus.store');
    Route::get('/restaurant_owner/menus/{menu}/edit', [RestaurantOwnerController::class, 'menuEdit'])->name('restaurant.menus.edit');
    Route::put('/restaurant_owner/menus/{menu}/update', [RestaurantOwnerController::class, 'menuUpdate'])->name('restaurant.menus.update');
    Route::delete('/restaurant_owner/menus/{menu}', [RestaurantOwnerController::class, 'menuDestroy'])->name('restaurant.menus.destroy');

    Route::get('/restaurant/profile', [RestaurantOwnerController::class, 'restaurantProfile'])->name('restaurant.profile');
    Route::get('/restaurant/profile/edit', [RestaurantOwnerController::class, 'restaurantEdit'])->name('restaurant.profile.edit');
    Route::put('/restaurant/profile/update/{restaurant}', [RestaurantOwnerController::class, 'restaurantUpdate'])->name('restaurant.profile.update');
    Route::get('/restaurant/profile/create', [RestaurantOwnerController::class, 'restaurantCreate'])->name('restaurant.profile.create');
    Route::post('/restaurant/profile/store', [RestaurantOwnerController::class, 'restaurantStore'])->name('restaurant.profile.store');

    //sub
    Route::get('/subscribe', [SubscriptionController::class, 'showSubscriptionForm'])->name('subscription.form');
    Route::post('/subscribe', [SubscriptionController::class, 'processSubscription'])->name('subscription.process');
});


// social login routes
Route::get('/auth/google', [AuthenticatedSessionController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthenticatedSessionController::class, 'handleGoogleCallback']);



require __DIR__.'/auth.php';
