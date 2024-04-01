<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Admin\AdminController;

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


// Admin APIs
require 'admin/__api.php';

// Customer APIs
require 'customer/__api.php';

// Salesperson APIs
require 'salesperson/__api.php';

// Route::prefix('user')->middleware('auth:sanctum')->group( function () {
//     Route::apiResources([

// 	]);
// });

// Route::prefix('salesperson')->middleware('auth:salesperson')->group( function () {
//     Route::apiResources([

// 	]);
// });
