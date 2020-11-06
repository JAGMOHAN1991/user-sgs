<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController;

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

Route::get('/binary-search', [ApiAuthController::class, 'getBinaryData'])
     ->name('binary');

Route::group(['middleware' => ['json.response']], function () {
    // public routes
    Route::post('/oauth/token', [ApiAuthController::class, 'login'])
         ->name('login.api');
    Route::post('/register', [ApiAuthController::class, 'register'])
         ->name('register.api');
});


Route::middleware('api.superAdmin')->group(function () {
    Route::get('/login_data', [ApiAuthController::class, 'welcome'])
         ->name('login_data');
    Route::post('/logout', [ApiAuthController::class, 'logout'])
         ->name('logout.api');
});
