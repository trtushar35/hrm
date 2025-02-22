<?php

use App\Http\Controllers\Api\V1\ModuleMakerController;
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

Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {
    Route::post('/module-make', [ModuleMakerController::class, 'index'])->name('moduleMaker');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
