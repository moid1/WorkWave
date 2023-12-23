<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\CompanyRegController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FullFillOrderController;
use App\Http\Controllers\ManifestPDFController;
use App\Http\Controllers\NotesController;
use App\Models\ManifestPDF;

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
    return redirect('/login');
});

Auth::routes();

Route::get('/manifestsssss', [HomeController::class,'getManifest'])->name('manifest');

Route::get('/home', [HomeController::class, 'index'])->name('home');

//Register Manager
Route::get('/register-manager',  [UserController::class, 'index'])->name('register.manager');
Route::post('/create-manager',  [UserController::class, 'createManager'])->name('create.manager');

//Register Manager
Route::get('/register-driver',  [DriverController::class, 'index'])->name('register.driver');
Route::post('/create-driver',  [DriverController::class, 'store'])->name('create.driver');
Route::get('/driver-delete/{id}',  [DriverController::class, 'deleteDriver'])->name('driver.delete');
Route::get('/get-driver-orders/{id}', [DriverController::class,'getOrders'])->name('driver.orders');


//Customers
Route::get('/register-customer',  [CustomerController::class, 'create'])->name('register.customer');
Route::get('/customers',  [CustomerController::class, 'index'])->name('customers.index');

Route::get('/create-customer',  [UserController::class, 'createCustomer'])->name('create.customer');
Route::post('/add-customer',  [CustomerController::class, 'store'])->name('customer.store');
Route::get('/show-customer/{id}',  [CustomerController::class, 'show'])->name('customer.show');
Route::post('customer-update/{id}',[CustomerController::class,'update'])->name('customer.update');

Route::get('/customers/search',[CustomerController::class,'searchCustomers'])->name('customer.search');
Route::get('/toggle-customer-status/{id}',[CustomerController::class,'toggleCustomerStatus']);

//Orders
Route::get('/orders',  [OrderController::class, 'index'])->name('order.index');
Route::get('/create-orders',  [OrderController::class, 'create'])->name('order.create');
Route::post('/orders',  [OrderController::class, 'store'])->name('order.store');
Route::post('/assign-driver', [OrderController::class,'updateDriver'])->name('order.updateDriver');

//Driver ORders
Route::get('/driver-orders',  [OrderController::class, 'driverOrders'])->name('order.driver.index');
Route::get('fulfill-order/{id}', [FullFillOrderController::class,'create'])->name('fulfillorder.create');
Route::post('fulfill-order', [FullFillOrderController::class,'store'])->name('fulfillorder.store');

Route::post('/notes', [NotesController::class, 'store'])->name('notes.store');
Route::get('/notes',  [NotesController::class, 'index'])->name('notes.index');
Route::get('/specifc-notes/{id}',  [NotesController::class, 'getUserNotes'])->name('notes.user');

Route::get('/books',[CustomerController::class,'getCustomers'])->name('books.customer');
Route::get('/books-list/{id}',[ManifestPDFController::class,'index'])->name('books.list');

Route::get('/company-registration',[CompanyRegController::class,'index'])->name('company.registration');
Route::post('/company-registration',[CompanyRegController::class,'store'])->name('company.registration.store');
Route::get('/company-registration/{id}',[CompanyRegController::class,'delete'])->name('company.registration.delete');

Route::get('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [HomeController::class, 'updatePassword'])->name('update-password');

Route::get('clear_cache', function () {

    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');

    dd("Cache is cleared");

});

Route::get('migrate', function () {

    \Artisan::call('migrate');

    dd("Migration done");

});

