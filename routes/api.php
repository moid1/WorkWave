<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
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


