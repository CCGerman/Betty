<?php

use App\Http\Controllers\Api\v1\AppointmentController;
use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\v1\ImageController;
use App\Http\Controllers\Api\v1\InvoiceController;
use App\Http\Controllers\Api\V1\WorkerController;
use App\Http\Controllers\Api\v1\LoginController;
use App\Http\Controllers\Api\v1\PaymentController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\TreatmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);

Route::middleware('auth:sanctum')
    ->resource('worker', WorkerController::class)
    ->only(['index', 'store', 'show', 'update', 'destroy']);

Route::middleware('auth:sanctum')
    ->resource('client', ClientController::class)
    ->only(['index', 'store', 'show', 'update', 'destroy']);
        
Route::middleware('auth:sanctum')
    ->resource('product', ProductController::class)
    ->only(['index', 'store', 'show', 'update', 'destroy']);

Route::middleware('auth:sanctum')
    ->resource('treatment', TreatmentController::class)
    ->only(['index', 'store', 'show', 'update', 'destroy']);

Route::middleware('auth:sanctum')
    ->resource('appointment', AppointmentController::class)
    ->only(['index', 'store', 'show', 'update', 'destroy']);


Route::middleware('auth:sanctum')
    ->resource('invoice', InvoiceController::class)
    ->only(['index', 'store']);
    Route::middleware('auth:sanctum')
    ->get('/invoice/{serie}/{id}', [InvoiceController::class, 'show'])
    ->name('invoice.show');
Route::middleware('auth:sanctum')
    ->delete('/invoice/{serie}/{id}', [InvoiceController::class, 'destroy'])
    ->name('invoice.destroy');

Route::middleware('auth:sanctum')
    ->resource('payment', PaymentController::class)
    ->only(['index', 'store', 'show', 'update', 'destroy']);

Route::middleware('auth:sanctum')
    ->resource('image', ImageController::class)->only(['destroy']);