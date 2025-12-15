<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Customer\BookController as CustomerBookController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CollectionController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/books', [CustomerBookController::class, 'index'])->name('customer.books.index');
Route::get('/books/{book}', [CustomerBookController::class, 'show'])->name('customer.books.show');


Route::middleware(['auth'])->name('customer.')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    Route::post('/books/{book}/reviews', [CustomerBookController::class, 'storeReview'])->name('books.reviews.store');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart-clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::delete('/cart-bulk-delete', [CartController::class, 'bulkDelete'])->name('cart.bulkDelete');

    Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
    Route::match(['get', 'post'], '/orders/checkout', [CustomerOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [CustomerOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/confirm', [CustomerOrderController::class, 'confirm'])->name('orders.confirm');
    Route::patch('/orders/{order}/cancel', [CustomerOrderController::class, 'cancel'])->name('orders.cancel');

    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
    Route::post('/collections', [CollectionController::class, 'store'])->name('collections.store');
    Route::delete('/collections/delete', [CollectionController::class, 'destroy'])->name('collections.destroy');

    Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/{review}/like', [ReviewController::class, 'like'])->name('reviews.like');
    Route::delete('/reviews/{review}/unlike', [ReviewController::class, 'unlike'])->name('reviews.unlike');
    Route::post('/reviews/{review}/report', [ReviewController::class, 'report'])->name('reviews.report');


    // payment

    Route::get('/orders/{order}/payment', [CustomerOrderController::class, 'payment'])
        ->name('orders.payment');
    Route::get('/orders/{order}/payment/callback', [CustomerOrderController::class, 'paymentCallback'])
        ->name('orders.payment.callback');
});

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [AdminDashboard::class, 'getChartData'])->name('dashboard.chart');

    Route::resource('books', AdminBookController::class);

    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/reports/export', [AdminReportController::class, 'exportMonthly'])->name('reports.export');
});


require __DIR__ . '/auth.php';
