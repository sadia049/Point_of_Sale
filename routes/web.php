<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
//API Routes
Route::post('/Registration',[UserController::class,'registration']);
Route::post('/Login',[UserController::class,'Login']);
Route::post('/send-OTP',[UserController::class,'sendOTP']);
Route::post('/verify-OTP',[UserController::class,'verifyOtp']);
Route::post('/reset-password',[UserController::class,'resetPassword'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/user-profile',[UserController::class,'userProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-profile',[UserController::class,'updateProfile'])->middleware([TokenVerificationMiddleware::class]);


//Page Routes

Route::get('/userRegistration',[UserController::class,'userRegistrationView']);
Route::get('/userLogin',[UserController::class,'userLoginView']);
Route::get('/sendOTP',[UserController::class,'sendOTPview']);
Route::get('/verifyOTP',[UserController::class,'verifyOTPview']);
Route::get('/resetPassword',[UserController::class,'resetPasswordview'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/dashboard',[DashboardController::class,'dashboardView'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/profile',[UserController::class,'profilePageView'])->middleware([TokenVerificationMiddleware::class]);
