<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HICController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MedController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PrescriptionController;

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


Auth::routes();


Route::get('/main', [UserController::class, 'showMainPage'])->name('main');


Route::resource('users', UserController::class);

Route::resource('hics', HICController::class);

Route::resource('categories', CategoryController::class);

Route::resource('medicines', MedController::class);

Route::get('/medicines.storePage', [MedController::class, 'storePage'])->name('medicines.storePage');


Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show'); // Display cart
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add'); // Add medicine to cart
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove'); // Remove a specific item from the cart
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear'); // Clear all items from the cart
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout'); // Proceed to checkout
Route::post('/switch-request/{newRequestId}', [CartController::class, 'switchRequest'])->name('switchRequest');



Route::resource('prescriptions', PrescriptionController::class);

Route::get('/requests', [PrescriptionController::class, 'requests'])->name('requests.index');

Route::get('/dashboard', function () {
    return view('dashWelcome');
})->name('dashboard');


Route::get('/prescriptions/{id}/bill', [PrescriptionController::class, 'showBill'])->name('prescriptions.bill');
