<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionalMailController;
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
//Auth API Routes
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
Route::get('/categoryPage',[CategoryController::class,'CategoryPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/productPage',[ProductController::class,'ProductPage'])->middleware([TokenVerificationMiddleware::class]);

//Category API Routes
Route::middleware([TokenVerificationMiddleware::class])->group(function(){
    Route::post("/create-category",[CategoryController::class,'CategoryCreate']);
    Route::get("/list-category",[CategoryController::class,'CategoryList']);
    Route::post("/delete-category",[CategoryController::class,'CategoryDelete']);
    Route::post("/update-category",[CategoryController::class,'CategoryUpdate']);
    Route::post("/category-by-id",[CategoryController::class,'CategoryByID']);


});
//Customer API Routes
Route::middleware([TokenVerificationMiddleware::class])->group(function(){
    Route::post("/create-customer",[CustomerController::class,'CustomerCreate']);
    Route::get("/list-customer",[CustomerController::class,'CustomerList']);
    Route::post("/delete-customer",[CustomerController::class,'CustomerDelete']);
    Route::post("/update-customer",[CustomerController::class,'CustomerUpdate']);
    Route::post("/customer-by-id",[CustomerController::class,'CustomerById']);


});

//Product API


Route::middleware([TokenVerificationMiddleware::class])->group(function(){

    Route::post("/create-product",[ProductController::class,'CreateProduct']);
    Route::post("/delete-product",[ProductController::class,'DeleteProduct']);
    Route::post("/update-product",[ProductController::class,'UpdateProduct']);
    Route::get("/list-product",[ProductController::class,'ProductList']);
    Route::post("/product-by-id",[ProductController::class,'ProductByID']);
    


});

//Promotional mail api
Route::middleware(TokenVerificationMiddleware::class)->group(function(){
    
    Route::get('/send-promotion-page',[PromotionalMailController::class,'PromotionalMailPage']);
    Route::post('/send-promotion',[PromotionalMailController::class,'PromotionalContent']);

});


  




