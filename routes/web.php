<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get("/", [UserController::class, "getHome"]);
Route::post('/filter-partner-suggetion', [UserController::class, "postFilterPartnerSuggestion"]);

Route::get("/login", [UserController::class, "getLogin"]);
Route::post("/login", [UserController::class, 'postLogin']);

Route::get("/signup", [UserController::class, "getSignup"]);
Route::post("/signup", [UserController::class, "postSignup"]);

Route::get("/partner-preference", [UserController::class, "getPartnerPreference"]);
Route::post("/partner-preference", [UserController::class, "postPartnerPreference"]);

Route::get("/profile", [UserController::class, "getProfile"]);
Route::post("/profile", [UserController::class, "postProfile"]);

Route::get("/logout", [UserController::class, "getLogout"]);

Route::get('/auth/google/redirect', [UserController::class, 'getGoogleRedirect']);

Route::get('/auth/google/callback', [UserController::class, 'getGoogleCallback']);
