<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\HomeScreenController;
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

Route::group(['middleware' => ['api']], function () {

    if (request()->header('Authorization')) {
        Route::group(
            ['middleware' => 'auth:sanctum'],
            function () {
                Route::post('/order', [AuthController::class, 'order']);
                Route::post('/addCoupon', [AuthController::class, 'addCoupon']);
                Route::get('/getOrders', [HomeScreenController::class, 'getOrders']);
                Route::get('/tourGuide', [HomeScreenController::class, 'tourGuide']);
                Route::get('/myAds', [HomeScreenController::class, 'myAds']);
                Route::post('/deleteAds', [HomeScreenController::class, 'deleteAds']);
                Route::post('/searchOrders', [HomeScreenController::class, 'searchOrders']);
                Route::post('/verifyOtp', [AuthController::class, 'verifyOtp']);
                Route::post('/resendOtp', [AuthController::class, 'resendOtp']);
                Route::post('/logout', [AuthController::class, 'logout']);
                Route::post('/deleteAccount', [AuthController::class, 'deleteAccount']);
                Route::post('/updateProfile', [AuthController::class, 'updateProfile']);
                Route::post('/getProfileData', [AuthController::class, 'getProfileData']);
                Route::post('/updatePassword', [AuthController::class, 'updatePassword']);
                Route::get('/homeScreen', [HomeScreenController::class, 'homeScreen']);
                Route::get('/getAds', [HomeScreenController::class, 'getAds']);
                Route::get('/getAdsByCity', [HomeScreenController::class, 'getAdsByCity']);
                Route::get('/getAdsByCategory', [HomeScreenController::class, 'getAdsByCategory']);
                Route::post('/filter', [HomeScreenController::class, 'filter']);
                Route::get('/getRelatedAds', [HomeScreenController::class, 'getRelatedAds']);
                Route::get('/getCities/{id}', [HomeScreenController::class, 'getCitiesData']);
                Route::get('/getStreets', [HomeScreenController::class, 'getStreetsData']);
                Route::get('/getStreet', [HomeScreenController::class, 'getStreet']);
                Route::get('/checkUserDetials', [HomeScreenController::class, 'checkUserDetials']);
                Route::post('/addUserDetials', [HomeScreenController::class, 'addUserDetials']);
                Route::post('/addService', [HomeScreenController::class, 'addService']);
                Route::post('/addTravel', [HomeScreenController::class, 'addTravel']);
                Route::post('/addFavourite', [FavouriteController::class, 'addFavourite']);
                Route::get('/wheel_of_fortunes', [HomeScreenController::class, 'wheel_of_fortunes']);
                Route::post('/addWheel', [HomeScreenController::class, 'addWheel']);
                Route::post('/addWallet', [HomeScreenController::class, 'addWallet']);
                Route::get('/getWallet', [HomeScreenController::class, 'getWallet']);
                Route::get('/splach', [HomeScreenController::class, 'splach']);
                Route::get('/getNotifications', [HomeScreenController::class, 'getNotifications']);
                Route::post('/deleteNotification', [HomeScreenController::class, 'deleteNotification']);
                Route::post('/seeNotification', [HomeScreenController::class, 'seeNotification']);
                Route::get('/getCommenets', [HomeScreenController::class, 'getCommenets']);
                Route::get('/getFavouries', [FavouriteController::class, 'getFavouries']);
            }
        );
    } else {
        Route::get('/getCountres', [DataController::class, 'getCountres']);
        Route::get('/getAccompanying', [DataController::class, 'getAccompanying']);
        Route::get('/travel_country', [DataController::class, 'travel_country']);
        Route::get('/travel_type', [DataController::class, 'travel_type']);
        Route::get('/event_type', [DataController::class, 'event_type']);
        Route::get('/gide_type', [DataController::class, 'gide_type']);
        Route::get('/languages', [DataController::class, 'languages']);
        Route::get('/markiting_type', [DataController::class, 'markiting_type']);
        Route::get('/about', [DataController::class, 'about']);
        Route::get('/info', [DataController::class, 'info']);
        Route::get('/socialMedia', [DataController::class, 'socialMedia']);
        Route::get('/terms', [DataController::class, 'terms']);
        Route::get('/questions', [DataController::class, 'questions']);
        Route::get('/privacies', [DataController::class, 'privacies']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/forgetPassword', [AuthController::class, 'forgetPassword']);
        Route::post('/changePassword', [AuthController::class, 'changePassword']);
        Route::get('/splach', [HomeScreenController::class, 'splach']);
        Route::get('/date', [HomeScreenController::class, 'date']);
        Route::get('/payment', [\App\Http\Controllers\Api\Payment::class, 'index']);
        Route::post('/payment', [\App\Http\Controllers\Api\Payment::class, 'post']);
    }
});
