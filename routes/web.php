<?php

use Carbon\Carbon;
use App\Http\Controllers;
use Illuminate\Support\Facades\{Artisan, Route};


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


Route::middleware([ 'auth:web', 'middleware' => 'language' ])->group(function () {
    Route::get('/', [Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::extendedResources([
        'roles'         => Controllers\RoleController::class,
        'users'         => Controllers\UserController::class,
        'warehouses'    => Controllers\WarehouseController::class,
        'categories'    => Controllers\CategoryController::class,
        'items'         => Controllers\ItemController::class,
        'transfers'     => Controllers\TransferController::class,
        'adjustments'   => Controllers\AdjustmentController::class,
        'checkins'      => Controllers\CheckinController::class,
        'checkouts'     => Controllers\CheckoutController::class,
        'contacts'      => Controllers\ContactController::class,
        'units'         => Controllers\UnitController::class,
        'settings'      => Controllers\SettingController::class,
    ]);
    
    Route::portResources([
        'warehouses'    => Controllers\Port\WarehousePortController::class,
        'categories'    => Controllers\Port\CategoryPortController::class,
        'items'         => Controllers\Port\ItemPortController::class,
        'contacts'      => Controllers\Port\ContactPortController::class,
        'units'         => Controllers\Port\UnitPortController::class,
    ]);
    
    Route::apiResources([
        'warehouses'    => Controllers\Api\WarehouseController::class,
        'items'         => Controllers\Api\ItemController::class,
    ]);

    Route::post('/items/search', [Controllers\Api\ItemController::class, 'search'])->name('items.search');
    Route::get('/items/{item}/trail', [Controllers\ItemController::class, 'trail'])->name('items.trail');

    // Reports
    Route::get('reports', [Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::match(['GET', 'POST'], 'reports/checkin', [Controllers\ReportController::class, 'checkin'])->name('reports.checkin');
    Route::match(['GET', 'POST'], 'reports/checkout', [Controllers\ReportController::class, 'checkout'])->name('reports.checkout');
    Route::match(['GET', 'POST'], 'reports/transfer', [Controllers\ReportController::class, 'transfer'])->name('reports.transfer');
    Route::match(['GET', 'POST'], 'reports/adjustment', [Controllers\ReportController::class, 'adjustment'])->name('reports.adjustment');
});

Route::get('download', function(){
    $filePath = request()->fp;
    $fileName = request()->fn;
    
    return response()->download(storage_path('app/' . $filePath), $fileName);
})->name('download');