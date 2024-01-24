<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FullFillOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\OrderController;
use App\Models\FullFillOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class,'loginUser']);
Route::post('/register-manager', [AuthController::class,'registerManager'])->middleware('auth:sanctum');
Route::post('/register-driver', [AuthController::class, 'registerDriver'])->middleware('auth:sanctum');
Route::post('/register-customer', [AuthController::class, 'registerCustomer'])->middleware('auth:sanctum');
Route::get('/get-dashboard-stats',[HomeController::class,'getDashboardStats'])->middleware('auth:sanctum');
Route::get('/get-customers',[CustomerController::class,'apiGetCustomers'])->middleware('auth:sanctum');
Route::get('/get-customer-manifest',[CustomerController::class,'apiGetCustomersManifest'])->middleware('auth:sanctum');
Route::post('/assign-driver', [OrderController::class,'apiUpdateDriver'])->middleware('auth:sanctum');
Route::get('/get-all-managers', [ManagerController::class, 'apiGetAllManagers'])->middleware('auth:sanctum');
Route::get('/get-all-drivers', [ManagerController::class, 'apiGetAllDrivers'])->middleware('auth:sanctum');
Route::get('/get-all-customer-notes', [NotesController::class, 'apiGetAllCustomersNotes'])->middleware('auth:sanctum');
Route::post('/change-password', [AuthController::class, 'apiChangePassword'])->middleware('auth:sanctum');

//Orders
Route::get('/get-orders', [OrderController::class, 'apiGetOrders'])->middleware('auth:sanctum');
Route::post('/order', [OrderController::class,'apiCreateOrder'])->middleware('auth:sanctum');
Route::post('tdf-order', [FullFillOrderController::class, 'apiFulFillTDFOrder'])->middleware('auth:sanctum');

//Customers

Route::get('get-customers-order', [CustomerController::class, 'apiGetCustomerOrders'])->middleware('auth:sanctum');
Route::get('get-driver-orders', [DriverController::class, 'apiGetLoggedInDriverOrders'])->middleware('auth:sanctum');

Route::get('driver-orders/{id}', [DriverController::class, 'apiGetDriverOrders'])->middleware('auth:sanctum');