<?php

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

Route::get('/units', [\App\Http\Controllers\API\UnitController::class, 'index']);
Route::get('/master-items', [\App\Http\Controllers\API\MasterItemController::class, 'index']);
Route::get('/kiosk/tables', [\App\Http\Controllers\TableController::class, 'listAllApi']);
