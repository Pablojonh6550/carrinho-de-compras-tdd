<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CartController;

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

Route::get("/ping", function () {
    return response()->json([
        "pong"
    ]);
});

Route::post("/cart/finish", [CartController::class, "finishCart"]);
