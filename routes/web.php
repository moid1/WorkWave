<?php

use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\CalanderController;
use App\Http\Controllers\CallingTableController;
use App\Http\Controllers\GeneralController;
use App\Models\CallingTable;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyRegController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerPricingController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\FullFillOrderController;
use App\Http\Controllers\ManagerCompareOrderController;
use App\Http\Controllers\ManifestPDFController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\UnfillManifestController;
use App\Models\Order;

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
Route::view('privacy-policy', 'privacy');
Route::get('/manifestsssss', [HomeController::class, 'getManifest'])->name('manifest');

Route::get('/home', [HomeController::class, 'index'])->name('home');

//Register Manager
Route::get('/register-manager',  [UserController::class, 'index'])->name('register.manager');
Route::get('/manager/{id}',  [UserController::class, 'showManagerDetails'])->name('manager.show');
Route::post('/create-manager',  [UserController::class, 'createManager'])->name('create.manager');
Route::post('/update-manager',  [UserController::class, 'updateManager'])->name('manager.update');
Route::get('delete-manager/{id}', [UserController::class, 'deleteManager'])->name('manager.delete');

//Register Driver
Route::get('/register-driver',  [DriverController::class, 'index'])->name('register.driver');
Route::post('/create-driver',  [DriverController::class, 'store'])->name('create.driver');
Route::get('/driver-delete/{id}',  [DriverController::class, 'deleteDriver'])->name('driver.delete');
Route::get('/get-driver-orders/{id}', [DriverController::class, 'getOrders'])->name('driver.orders');
Route::get('/driver/{id}', [DriverController::class, 'showDriverDetails'])->name('driver.show');
Route::post('/update-driver',  [DriverController::class, 'updateDriver'])->name('driver.update');


//Customers
Route::get('/register-customer',  [CustomerController::class, 'create'])->name('register.customer');
Route::get('/customers',  [CustomerController::class, 'index'])->name('customers.index');

Route::get('/create-customer',  [UserController::class, 'createCustomer'])->name('create.customer');
Route::post('/add-customer',  [CustomerController::class, 'store'])->name('customer.store');
Route::get('/show-customer/{id}',  [CustomerController::class, 'show'])->name('customer.show');
Route::post('customer-update/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::get('fetch-customer', [CustomerController::class, 'fetchCustomer'])->name('customer.fetch');

Route::get('/customers/search', [CustomerController::class, 'searchCustomers'])->name('customer.search');
Route::get('/customers/search-books', [CustomerController::class, 'searchCustomersBooks'])->name('customer.search.books');

Route::get('/toggle-customer-status/{id}', [CustomerController::class, 'toggleCustomerStatus']);

//Orders
Route::get('/orders',  [OrderController::class, 'index'])->name('order.index');
Route::get('/delete-order/{id}', [OrderController::class, 'deleteOrder'])->name('order.delete');
Route::get('/late-orders',  [OrderController::class, 'lateOrders'])->name('orders.late');
Route::get('order/{id}', [OrderController::class, 'getOrderById'])->name('order.show');
Route::get('/create-orders',  [OrderController::class, 'create'])->name('order.create');
Route::post('/orders',  [OrderController::class, 'store'])->name('order.store');
Route::post('/assign-driver', [OrderController::class, 'updateDriver'])->name('order.updateDriver');
Route::post('update-order', [OrderController::class, 'updateOrder'])->name('order.updateOrder');
Route::get('/orders-by-driver', [OrderController::class, 'ordersByDriver'])->name('order.drivers');

//Driver ORders
Route::get('/driver-orders',  [OrderController::class, 'driverOrders'])->name('order.driver.index');
Route::get('/driver-orders-manifest',  [OrderController::class, 'getTodaysManifestForDriver'])->name('order.driver.manifest');

Route::get('fulfill-order/{id}', [FullFillOrderController::class, 'create'])->name('fulfillorder.create');
Route::post('fulfill-order', [FullFillOrderController::class, 'store'])->name('fulfillorder.store');
Route::get('/load-weight/{id}', [FullFillOrderController::class, 'loadByWeight'])->name('fullfill.load.weight');
Route::get('/load-tire/{id}', [FullFillOrderController::class, 'loadByTire'])->name('fullfill.load.tire');

Route::get('fulfilled-orders', [FullFillOrderController::class, 'getFullFilledOrders'])->name('orders.fullfilled');

Route::post('/notes', [NotesController::class, 'store'])->name('notes.store');
Route::get('/notes',  [NotesController::class, 'index'])->name('notes.index');
Route::get('/specifc-notes/{id}',  [NotesController::class, 'getUserNotes'])->name('notes.user');

Route::get('/books', [CustomerController::class, 'getCustomers'])->name('books.customer');
Route::get('/books-list/{id}', [ManifestPDFController::class, 'index'])->name('books.list');

Route::get('/company-registration', [CompanyRegController::class, 'index'])->name('company.registration');
Route::post('/company-registration', [CompanyRegController::class, 'store'])->name('company.registration.store');
Route::get('/company-registration/{id}', [CompanyRegController::class, 'delete'])->name('company.registration.delete');

Route::get('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [HomeController::class, 'updatePassword'])->name('update-password');

Route::get('/calander', [CalanderController::class, 'index'])->name('calander.index');
Route::get('/calander-event', [CalanderController::class, 'eventsForCalander'])->name('calander.events');

Route::get('/calander-order', [CalanderController::class, 'viewForOrderCalander'])->name('calander.order.view');
Route::get('/calander-orders', [CalanderController::class, 'ordersForCalander'])->name('calander.order');

Route::get('/swap-calander', [CalanderController::class, 'viewForSwapCalander'])->name('calander.swap.view');
Route::get('/swap-calander-orders', [CalanderController::class, 'swapOrdersCalander'])->name('calander.swap.orders');

Route::post('/calander-update-order', [CalanderController::class, 'changeOrderDate'])->name('calander.order.update');

Route::get('clear_cache', function () {

    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');

    dd("Cache is cleared");
});

Route::get('migrate', function () {

    \Artisan::call('migrate');

    dd("Migration done");
});

Route::get('/compare-order/{id}', [FullFillOrderController::class, 'compareOrder'])->name('compare.order');
Route::post('/compare-order', [ManagerCompareOrderController::class, 'store'])->name('manager.compare.order.post');

Route::get('/compared-orders', [OrderController::class, 'getComparedOrders'])->name('orders.compared');

Route::view('count-sheet', 'countsheet.index');

Route::get('/generate-count-sheet/{id}', [ManagerCompareOrderController::class, 'generateCountSheet'])->name('generate.countsheet');
Route::get('/generate-weight-sheet/{id}', [ManagerCompareOrderController::class, 'generateWeightSheet'])->name('generate.weightsheet');


//Truck
Route::get('/truck', [TruckController::class, 'index'])->name('truck.index');
Route::post('/truck', [TruckController::class, 'store'])->name('truck.store');
Route::get('/live-trucks', [TruckController::class, 'liveTrucks'])->name('truck.live');
Route::get('/truck-status/{id}', [TruckController::class, 'changeTruckStatus'])->name('change.truck.status');
Route::get('/update-truck/{id}', [TruckController::class, 'updateTruck'])->name('truck.update');
Route::post('/update-truck/{id}', [TruckController::class, 'updateTruckStore'])->name('truck.update');
Route::post('/assign-truck', [TruckController::class, 'assignTruckToDriver'])->name('assign.truck.driver');

//Customer Pricing

Route::get('/customer-pricing', [CustomerPricingController::class, 'index'])->name('customer.pricing.index');
Route::get('/customer-pricing/{id}', [CustomerPricingController::class, 'create'])->name('customer.pricing.create');
Route::post('/customer-pricing', [CustomerPricingController::class, 'store'])->name('customer.pricing.store');

Route::post('/tdf-order', [FullFillOrderController::class, 'tdfOrderCreate'])->name('order.store.tdf');
Route::post('/trailer-swap-order', [FullFillOrderController::class, 'trailerSwapCreate'])->name('order.store.trailer.swap');
Route::post('/state-weight', [FullFillOrderController::class, 'stateByWeight'])->name('order.store.state.weight');
Route::post('/steel', [FullFillOrderController::class, 'steelOrderCreate'])->name('order.store.steel');

Route::get('generate-daily-count-sheet', [HomeController::class, 'generateDailyCountSheet'])->name('generate.daily.count.sheet');

//ADMIN SETTINGS

Route::get('admin-settings', [AdminSettingsController::class, 'index'])->name('admin.settings.index');
Route::post('admin-settings', [AdminSettingsController::class, 'store'])->name('admin.settings.store');

Route::get('fill-manifest', [OrderController::class, 'getUnfilledManifest'])->name('fill.manifest.index');
Route::get('fill-manifest/{id}', [OrderController::class, 'getUnfilledManifestOrder'])->name('unfill.manifest.order');
Route::post('fill-manifest-order', [UnfillManifestController::class, 'store'])->name('unfill.fill.order');


Route::post('get-customer-last-notes', [NotesController::class, 'getLastNote'])->name('customer.last.note');

Route::get('create-route', [RoutingController::class, 'createRouting'])->name('routing.create');
Route::get('get-routes', [RoutingController::class, 'getRoutes'])->name('routing.all');
Route::get('delete-route/{id}', [RoutingController::class, 'deleteRouteWeb'])->name('routing.delete');

Route::get('get-driver-orders-routing', [RoutingController::class, 'getDriverOrderRouting']);

Route::post('create-routing-web', [RoutingController::class, 'createWebRoute']);

Route::get('calling-table', [CallingTableController::class, 'index'])->name('calling.table.index');
Route::get('create-calling-table', [CallingTableController::class, 'create'])->name('calling.table.create');
Route::post('calling-table', [CallingTableController::class, 'store'])->name('calling.table.store');
Route::get('delete-calling-table', [CallingTableController::class, 'deleteCallingTable'])->name('calling.table.delete');

Route::get('/trailer-report', [GeneralController::class, 'trailerSwapReport'])->name('trailer.swap.create');

Route::get('/get-orders-by-truck_routed', [GeneralController::class, 'getOrdersByTruckRouted']);

Route::post('/get-order-dragging', [RoutingController::class, 'checkOrderDragging']);

Route::get('/trailer-search-view', [GeneralController::class, 'getSearachTrailerView'])->name('trailer.search.view');
Route::post('/getSearchTrailerData', [GeneralController::class, 'getSearchTrailerData'])->name('trailer.search.post');

Route::post('/update-trailer-status', [GeneralController::class, 'updateTrailerData'])->name('update.trailer.data');


