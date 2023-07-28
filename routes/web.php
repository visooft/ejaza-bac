<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AddtionsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DateController;
use App\Http\Controllers\Admin\DelivaryController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\financialReportsController;
use App\Http\Controllers\Admin\GuideController;
use App\Http\Controllers\Admin\InfoController;
use App\Http\Controllers\Admin\LangController;
use App\Http\Controllers\Admin\MarketController;
use App\Http\Controllers\Admin\MenueController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ResturantController;
use App\Http\Controllers\Web\ResturantController as WebResturantController;
use App\Http\Controllers\Admin\ResturantProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Seller\RoleController as sellerRoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SocialsController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\StreetController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\SubMenueController;
use App\Http\Controllers\Admin\TravelController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\WheelOfFortunesController;
use App\Http\Controllers\Seller\OrderController as orderSellerController;
use App\Http\Controllers\Seller\productController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Livewire\DateMange;
use App\Http\Livewire\Payments;
use Illuminate\Support\Facades\Route;

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


/**
 * Route For Authentications
 */

Route::get('/Challahrequest/{user_id}/{phone}', [HomeController::class, 'index'])->name('index');
Route::get('/resturants', [WebResturantController::class, 'index'])->name('resturant');
Route::get('/stores', [WebResturantController::class, 'stores'])->name('stores');
Route::post('/registerResturant', [WebResturantController::class, 'registerResturant'])->name('registerResturant');
Route::post('/registerStore', [WebResturantController::class, 'registerStore'])->name('registerStore');
Route::post('/addCartGroup', [HomeController::class, 'addCartGroup'])->name('addCartGroup');
Route::post('/addToCart', [HomeController::class, 'addToCart'])->name('addToCart');
Route::post('/deleproduct', [HomeController::class, 'deleproduct'])->name('deleproduct');
Route::get('/lang/set/{lang}', [LangController::class, 'set'])->name('lang');
Route::get('/login', [AuthController::class, 'loginPage'])->name('loginPage');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/forget-password', [AuthController::class, 'showForgetPasswordForm'])->name('forget.password.get');

Route::post('/forget-password', [AuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('/reset-password', [AuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/searchCity', [DelivaryController::class, 'searchCity'])->name('searchCity');
Route::get('/MentanecMode', [AuthController::class, 'MentanecMode'])->name('MentanecMode');

Route::group(['prefix' => '/', 'middleware' => ['Admin', 'Lang']], function () {
    /**
     * Route For Dashboard Home Page
     */
    Route::get('/fcm-token', [AuthController::class, 'updateToken'])->name('fcmToken');
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::post('/notificationsStatus', [AdminController::class, 'notificationsStatus']);
    Route::get('/thisWeek', [AdminController::class, 'thisWeek']);
    Route::get('/thisMonth', [AdminController::class, 'thisMonth']);
    Route::get('/thisYear', [AdminController::class, 'thisYear']);
    Route::get('/thisWeekSeller', [AdminController::class, 'thisWeekSeller']);
    Route::get('/thisMonthSeller', [AdminController::class, 'thisMonthSeller']);
    Route::get('/thisYearSeller', [AdminController::class, 'thisYearSeller']);

    /**
     * Route For Roles Controller
     */
    Route::group(
        ['prefix' => '/roles', 'middleware' => 'can:roles'],
        function () {
            Route::get('/', [RoleController::class, 'index'])->name('roles');
            Route::post('/', [RoleController::class, 'store'])->name('role.store');
            Route::delete('/', [RoleController::class, 'delete'])->name('role.delete');
            Route::PUT('/', [RoleController::class, 'update'])->name('role.update');
            Route::get('/editRoles/{id}', [RoleController::class, 'edit'])->name('roles.edit');
        }
    );


    Route::group(
        ['prefix' => '/rolesSeller'],
        function () {
            Route::get('/', [sellerRoleController::class, 'index'])->name('rolesSeller');
            Route::post('/', [sellerRoleController::class, 'store'])->name('rolesSeller.store');
            Route::delete('/', [sellerRoleController::class, 'delete'])->name('rolesSeller.delete');
            Route::PUT('/', [sellerRoleController::class, 'update'])->name('rolesSeller.update');
            Route::get('/editRoles/{id}', [sellerRoleController::class, 'edit'])->name('rolesSeller.edit');
        }
    );

    /**
     * Route For User Controller
     */

    Route::group(
        ['prefix' => '/user', 'middleware' => 'can:users'],
        function () {
            Route::get('/', [UsersController::class, 'users'])->name('users');
            Route::get('Accountverification/{id}', [UsersController::class, 'Accountverification'])->name('Accountverification');
            Route::get('Accountdeclined/{id}', [UsersController::class, 'Accountdeclined'])->name('Accountdeclined');
            Route::delete('/', [UsersController::class, 'delete'])->name('user.delete');
            Route::post('/', [UsersController::class, 'store'])->name('user.store');
            Route::PUT('/', [UsersController::class, 'update'])->name('user.update');
            Route::get('/block/{id}', [UsersController::class, 'block'])->name('block');
            Route::get('/categoryBuy/{id}', [UsersController::class, 'categoryBuy'])->name('categoryBuy');
        }
    );
    Route::get('/getprofileUser/{id}', [UsersController::class, 'getprofile'])->name('getprofileUser');
    /**
     * Route for Admins
     */
    Route::group(
        ['prefix' => '/admins', 'middleware' => 'can:superAdmin'],
        function () {
            Route::get('/', [AdminController::class, 'index'])->name('admins');
            Route::get('/superAdmin', [AdminController::class, 'superAdmin'])->name('superAdmin');
            Route::delete('/', [AdminController::class, 'delete'])->name('superAdmin.delete');
            Route::post('/', [AdminController::class, 'store'])->name('superAdmin.store');
            Route::PUT('/', [AdminController::class, 'update'])->name('superAdmin.update');
            Route::get('/unBlock/{id}', [AdminController::class, 'unBlock'])->name('unBlock');
        }
    );
    /**
     * Route for embloyee
     */
    Route::group(
        ['prefix' => '/embloyee', 'middleware' => 'can:embloyee'],
        function () {
            Route::get('/', [EmployeeController::class, 'embloyee'])->name('embloyee');
            Route::delete('/', [EmployeeController::class, 'delete'])->name('embloyee.delete');
            Route::post('/', [EmployeeController::class, 'store'])->name('embloyee.store');
            Route::PUT('/', [EmployeeController::class, 'update'])->name('embloyee.update');
        }
    );


    /**
     * Route for Sliders
     */
    Route::group(
        ['prefix' => '/sliders'],
        function () {
            Route::get('/', [SliderController::class, 'sliders'])->name('sliders');
            Route::delete('/', [SliderController::class, 'delete'])->name('sliders.delete');
            Route::post('/', [SliderController::class, 'store'])->name('sliders.store');
            Route::post('/getProducts', [SliderController::class, 'getProducts'])->name('getProducts');
            Route::PUT('/', [SliderController::class, 'update'])->name('sliders.update');
            Route::PUT('/showSlider', [SliderController::class, 'showSlider'])->name('sliders.show');
            Route::PUT('/hideSlider', [SliderController::class, 'hideSlider'])->name('sliders.hide');
        }
    );

    /**
     * Route for Adspace
     */
    Route::group(
        ['prefix' => '/Adspace'],
        function () {
            Route::get('/', [SliderController::class, 'Adspace'])->name('Adspace');
            Route::delete('/', [SliderController::class, 'deleteAdspace'])->name('Adspace.delete');
            Route::post('/', [SliderController::class, 'storeAdspace'])->name('Adspace.store');
            Route::PUT('/', [SliderController::class, 'updateAdspace'])->name('Adspace.update');
            Route::PUT('/showSlider', [SliderController::class, 'showSliderAdspace'])->name('Adspace.show');
            Route::PUT('/hideSlider', [SliderController::class, 'hideSliderAdspace'])->name('Adspace.hide');
        }
    );
    /**
     * Route for Sliders
     */
    Route::group(
        ['prefix' => '/splach'],
        function () {
            Route::get('/', [SliderController::class, 'splach'])->name('splach');
            Route::delete('/', [SliderController::class, 'deletesplach'])->name('splach.delete');
            Route::post('/', [SliderController::class, 'storesplach'])->name('splach.store');
            Route::PUT('/', [SliderController::class, 'updatesplach'])->name('splach.update');
            Route::PUT('/showSlider', [SliderController::class, 'showSliderAsplach'])->name('splach.show');
            Route::PUT('/hideSlider', [SliderController::class, 'hideSlidersplach'])->name('splach.hide');
        }
    );
    /**
     * Route for country
     */
    Route::group(
        ['prefix' => '/country', 'middleware' => 'can:country'],
        function () {
            Route::get('/', [CountryController::class, 'country'])->name('country');
            Route::delete('/', [CountryController::class, 'delete'])->name('country.delete');
            Route::post('/', [CountryController::class, 'store'])->name('country.store');
            Route::PUT('/', [CountryController::class, 'update'])->name('country.update');
            Route::PUT('/showCountry', [CountryController::class, 'showCountry'])->name('country.show');
            Route::PUT('/hideCountry', [CountryController::class, 'hideCountry'])->name('country.hide');
        }
    );
    /**
     * Route for Cities
     */
    Route::group(
        ['prefix' => '/cities', 'middleware' => 'can:cities'],
        function () {
            Route::get('/{id}', [CityController::class, 'cities'])->name('cities');
            Route::delete('/', [CityController::class, 'delete'])->name('cities.delete');
            Route::post('/', [CityController::class, 'store'])->name('cities.store');
            Route::PUT('/', [CityController::class, 'update'])->name('cities.update');
            Route::PUT('/showCity', [CityController::class, 'showCity'])->name('cities.show');
            Route::PUT('/hideCity', [CityController::class, 'hideCity'])->name('cities.hide');
        }
    );
    /**
     * Route for Street
     */
    Route::group(
        ['prefix' => '/street', 'middleware' => 'can:cities'],
        function () {
            Route::get('/{id}', [StreetController::class, 'street'])->name('street');
            Route::delete('/', [StreetController::class, 'delete'])->name('street.delete');
            Route::post('/', [StreetController::class, 'store'])->name('street.store');
            Route::PUT('/', [StreetController::class, 'update'])->name('street.update');
            Route::PUT('/showStreet', [StreetController::class, 'showStreet'])->name('street.show');
            Route::PUT('/hideStreet', [StreetController::class, 'hideStreet'])->name('street.hide');
        }
    );

    /**
     * Route for Categories
     */
    Route::group(
        ['prefix' => '/category', 'middleware' => 'can:category'],
        function () {
            Route::get('/', [CategoryController::class, 'categories'])->name('category');
            Route::delete('/', [CategoryController::class, 'delete'])->name('category.delete');
            Route::post('/', [CategoryController::class, 'store'])->name('category.store');
            Route::PUT('/', [CategoryController::class, 'update'])->name('category.update');
            Route::PUT('/showCategory', [CategoryController::class, 'showCategory'])->name('category.show');
            Route::PUT('/hideCategory', [CategoryController::class, 'hideCategory'])->name('category.hide');
        }
    );

    /**
     * Route for Sub Category
     */
    Route::group(
        ['prefix' => '/subcategory', 'middleware' => 'can:subcategory'],
        function () {
            Route::get('/{id}', [SubCategoryController::class, 'subcategories'])->name('subcategory');
            Route::delete('/', [SubCategoryController::class, 'delete'])->name('subcategory.delete');
            Route::post('/', [SubCategoryController::class, 'store'])->name('subcategory.store');
            Route::PUT('/', [SubCategoryController::class, 'update'])->name('subcategory.update');
            Route::PUT('/showSubCategory', [SubCategoryController::class, 'showSubCategory'])->name('subcategory.show');
            Route::PUT('/hideSubCategory', [SubCategoryController::class, 'hideSubCategory'])->name('subcategory.hide');
        }
    );

    /**
     * Route for Resturants
     */

    Route::group(
        ['prefix' => '/ads', 'middleware' => 'can:ads'],
        function () {
            Route::get('/{id}/{status}', [ResturantController::class, 'ads'])->name('ads');
            Route::delete('/', [ResturantController::class, 'delete'])->name('ads.delete');
            Route::get('/detials/getDetials/{id}', [ResturantController::class, 'getDetials'])->name('getDetials');
            Route::post('/getResturantData', [ResturantController::class, 'getResturantData'])->name('getResturantData');
            Route::get('/ads/accepetResturant/{id}', [ResturantController::class, 'accepetResturant'])->name('accepetResturant');
            Route::get('/ads/rejecetResturant/{id}', [ResturantController::class, 'rejecetResturant'])->name('rejecetResturant');
            Route::PUT('/showAds', [ResturantController::class, 'showAds'])->name('ads.show');
            Route::PUT('/hideAds', [ResturantController::class, 'hideAds'])->name('ads.hide');
        }
    );


    Route::group(
        ['prefix' => '/accompanying', 'middleware' => 'can:ads'],
        function () {
            Route::get('/', [CategoryController::class, 'accompanying'])->name('accompanying');
            Route::delete('/', [CategoryController::class, 'accompanyingdelete'])->name('accompanying.delete');
            Route::post('/', [CategoryController::class, 'accompanyingstore'])->name('accompanying.store');
            Route::PUT('/', [CategoryController::class, 'accompanyingupdate'])->name('accompanying.update');
            Route::PUT('/showAds', [CategoryController::class, 'accompanyingshowAds'])->name('accompanying.show');
            Route::PUT('/hideAds', [CategoryController::class, 'accompanyinghideAds'])->name('accompanying.hide');
        }
    );
    Route::group(
        ['prefix' => '/travel_type', 'middleware' => 'can:ads'],
        function () {
            Route::get('/', [CategoryController::class, 'travel_type'])->name('travel_type');
            Route::delete('/', [CategoryController::class, 'travel_typedelete'])->name('travel_type.delete');
            Route::post('/', [CategoryController::class, 'travel_typestore'])->name('travel_type.store');
            Route::PUT('/', [CategoryController::class, 'travel_typeupdate'])->name('travel_type.update');
            Route::PUT('/showAds', [CategoryController::class, 'travel_typeshowAds'])->name('travel_type.show');
            Route::PUT('/hideAds', [CategoryController::class, 'travel_typehideAds'])->name('travel_type.hide');
        }
    );
    Route::group(
        ['prefix' => '/event_type', 'middleware' => 'can:ads'],
        function () {
            Route::get('/', [CategoryController::class, 'event_type'])->name('event_type');
            Route::delete('/', [CategoryController::class, 'event_typedelete'])->name('event_type.delete');
            Route::post('/', [CategoryController::class, 'event_typestore'])->name('event_type.store');
            Route::PUT('/', [CategoryController::class, 'event_typeupdate'])->name('event_type.update');
            Route::PUT('/showAds', [CategoryController::class, 'event_typeshowAds'])->name('event_type.show');
            Route::PUT('/hideAds', [CategoryController::class, 'event_typehideAds'])->name('event_type.hide');
        }
    );
    Route::group(
        ['prefix' => '/market_type', 'middleware' => 'can:ads'],
        function () {
            Route::get('/', [CategoryController::class, 'market_type'])->name('market_type');
            Route::delete('/', [CategoryController::class, 'market_typedelete'])->name('market_type.delete');
            Route::post('/', [CategoryController::class, 'market_typestore'])->name('market_type.store');
            Route::PUT('/', [CategoryController::class, 'market_typeupdate'])->name('market_type.update');
            Route::PUT('/showAds', [CategoryController::class, 'market_typeshowAds'])->name('market_type.show');
            Route::PUT('/hideAds', [CategoryController::class, 'market_typehideAds'])->name('market_type.hide');
        }
    );

    Route::group(
        ['prefix' => '/travel_country', 'middleware' => 'can:ads'],
        function () {
            Route::get('/', [CategoryController::class, 'travel_country'])->name('travel_country');
            Route::delete('/', [CategoryController::class, 'travel_countrydelete'])->name('travel_country.delete');
            Route::post('/', [CategoryController::class, 'travel_countrystore'])->name('travel_country.store');
            Route::PUT('/', [CategoryController::class, 'travel_countryupdate'])->name('travel_country.update');
            Route::PUT('/showAds', [CategoryController::class, 'travel_countryshowAds'])->name('travel_country.show');
            Route::PUT('/hideAds', [CategoryController::class, 'travel_countryhideAds'])->name('travel_country.hide');
        }
    );

    /**
     * Route for Stores
     */
    Route::group(
        ['prefix' => '/stores', 'middleware' => 'can:stores'],
        function () {
            Route::get('/{id}', [StoreController::class, 'stores'])->name('stores');
            Route::get('/edit/{id}', [StoreController::class, 'edit'])->name('edit');
            Route::delete('/', [StoreController::class, 'delete'])->name('stores.delete');
            Route::post('/', [StoreController::class, 'store'])->name('stores.store');
            Route::PUT('/', [StoreController::class, 'update'])->name('stores.update');
            Route::get('/accepetStore/{id}', [StoreController::class, 'accepetStore'])->name('accepetStore');
            Route::get('/rejecetStore/{id}', [StoreController::class, 'rejecetStore'])->name('rejecetStore');
            Route::PUT('/showStore', [StoreController::class, 'showStore'])->name('stores.show');
            Route::PUT('/hideStore', [StoreController::class, 'hideStore'])->name('stores.hide');
        }
    );

    /**
     * Route for menues
     */
    Route::group(
        ['prefix' => '/menues', 'middleware' => 'can:resturants'],
        function () {
            Route::get('/', [MenueController::class, 'menues'])->name('menues');
            Route::get('/menueStore', [MenueController::class, 'menueStore'])->name('menueStore');
            Route::delete('/', [MenueController::class, 'delete'])->name('menues.delete');
            Route::post('/', [MenueController::class, 'store'])->name('menues.store');
            Route::PUT('/', [MenueController::class, 'update'])->name('menues.update');
            Route::PUT('/show', [MenueController::class, 'show'])->name('menues.show');
            Route::PUT('/hide', [MenueController::class, 'hide'])->name('menues.hide');
        }
    );
    /**
     * Route for submenues
     */
    Route::group(
        ['prefix' => '/submenues'],
        function () {
            Route::get('/{id}', [SubMenueController::class, 'submenues'])->name('submenues');
            Route::delete('/', [SubMenueController::class, 'delete'])->name('submenues.delete');
            Route::post('/', [SubMenueController::class, 'store'])->name('submenues.store');
            Route::PUT('/', [SubMenueController::class, 'update'])->name('submenues.update');
            Route::PUT('/show', [SubMenueController::class, 'show'])->name('submenues.show');
            Route::PUT('/hide', [SubMenueController::class, 'hide'])->name('submenues.hide');
        }
    );

    /**
     * Route for products
     */
    Route::group(
        ['prefix' => '/products', 'middleware' => 'can:resturants'],
        function () {
            Route::get('/{id}', [ResturantProductController::class, 'products'])->name('products');
            Route::get('/add/{id}', [ResturantProductController::class, 'add'])->name('products.add');
            Route::get('/edit/{id}', [ResturantProductController::class, 'edit'])->name('editProduct');
            Route::get('/addStar/{id}', [ResturantProductController::class, 'addStar'])->name('addStar');
            Route::get('/deleteStar/{id}', [ResturantProductController::class, 'deleteStar'])->name('deleteStar');
            Route::delete('/', [ResturantProductController::class, 'delete'])->name('products.delete');
            Route::post('/store', [ResturantProductController::class, 'store'])->name('storePeoduct');
            Route::PUT('/', [ResturantProductController::class, 'update'])->name('products.update');
            Route::PUT('/show', [ResturantProductController::class, 'show'])->name('products.show');
            Route::PUT('/hide', [ResturantProductController::class, 'hide'])->name('products.hide');
        }
    );
    /**
     * Route for ProductSellerController
     */
    Route::group(
        ['prefix' => '/productStore', 'middleware' => 'can:merchant'],
        function () {
            Route::get('/menues/{id}', [productController::class, 'menues'])->name('productStoreMenue');
            Route::get('/productStore/{id}', [productController::class, 'productStore'])->name('productStore');
            Route::get('/add/{id}', [productController::class, 'add'])->name('productStore.add');
            Route::get('/edit/{id}', [productController::class, 'edit'])->name('editproductStore');
            Route::get('/addStar/{id}', [productController::class, 'addStar'])->name('addStarproductStore');
            Route::get('/deleteStar/{id}', [productController::class, 'deleteStar'])->name('deleteStarproductStore');
            Route::delete('/', [productController::class, 'delete'])->name('productStore.delete');
            Route::post('/', [productController::class, 'store'])->name('productStore.store');
            Route::PUT('/', [productController::class, 'update'])->name('productStore.update');
            Route::PUT('/show', [productController::class, 'show'])->name('productStore.show');
            Route::PUT('/hide', [productController::class, 'hide'])->name('productStore.hide');
        }
    );
    Route::post('productStore/getAdditionsData', [productController::class, 'getAdditions']);


    /**
     * Route for Info
     */
    Route::group(
        ['prefix' => '/info', 'middleware' => 'can:info'],
        function () {
            Route::get('/', [InfoController::class, 'info'])->name('info');
            Route::delete('/', [InfoController::class, 'delete'])->name('info.delete');
            Route::post('/', [InfoController::class, 'store'])->name('info.store');
            Route::PUT('/', [InfoController::class, 'update'])->name('info.update');
        }
    );
    /**
     * Route for Info
     */
    Route::group(
        ['prefix' => '/wheel_of_fortunes', 'middleware' => 'can:wheel_of_fortunes'],
        function () {
            Route::get('/', [WheelOfFortunesController::class, 'wheel_of_fortunes'])->name('wheel_of_fortunes');
            Route::delete('/', [WheelOfFortunesController::class, 'delete'])->name('wheel_of_fortunes.delete');
            Route::post('/', [WheelOfFortunesController::class, 'store'])->name('wheel_of_fortunes.store');
            Route::PUT('/', [WheelOfFortunesController::class, 'update'])->name('wheel_of_fortunes.update');
            Route::PUT('/show', [WheelOfFortunesController::class, 'show'])->name('wheel_of_fortunes.show');
            Route::PUT('/hide', [WheelOfFortunesController::class, 'hide'])->name('wheel_of_fortunes.hide');
        }
    );

    /**
     * Route for About
     */
    Route::group(
        ['prefix' => '/about', 'middleware' => 'can:about'],
        function () {
            Route::get('/', [AboutController::class, 'about'])->name('about');
            Route::delete('/', [AboutController::class, 'delete'])->name('about.delete');
            Route::post('/', [AboutController::class, 'store'])->name('about.store');
            Route::PUT('/', [AboutController::class, 'update'])->name('about.update');
        }
    );

    /**
     * Route for Terms
     */
    Route::group(
        ['prefix' => '/terms', 'middleware' => 'can:about'],
        function () {
            Route::get('/', [AboutController::class, 'terms'])->name('terms');
            Route::delete('/', [AboutController::class, 'deleteterms'])->name('terms.delete');
            Route::post('/', [AboutController::class, 'storeterms'])->name('terms.store');
            Route::PUT('/', [AboutController::class, 'updateterms'])->name('terms.update');
        }
    );

    /**
     * Route for Terms
     */
    Route::group(
        ['prefix' => '/questions', 'middleware' => 'can:about'],
        function () {
            Route::get('/', [AboutController::class, 'questions'])->name('questions');
            Route::delete('/', [AboutController::class, 'deletequestions'])->name('questions.delete');
            Route::post('/', [AboutController::class, 'storequestions'])->name('questions.store');
            Route::PUT('/', [AboutController::class, 'updatequestions'])->name('questions.update');
        }
    );

    /**
     * Route for Terms
     */
    Route::group(
        ['prefix' => '/privacies', 'middleware' => 'can:about'],
        function () {
            Route::get('/', [AboutController::class, 'privacies'])->name('privacies');
            Route::delete('/', [AboutController::class, 'deleteprivacies'])->name('privacies.delete');
            Route::post('/', [AboutController::class, 'storeprivacies'])->name('privacies.store');
            Route::PUT('/', [AboutController::class, 'updateprivacies'])->name('privacies.update');
        }
    );

    /**
     * Route for Socials
     */
    Route::group(
        ['prefix' => '/socials', 'middleware' => 'can:socials'],
        function () {
            Route::get('/', [SocialsController::class, 'socials'])->name('socials');
            Route::delete('/', [SocialsController::class, 'delete'])->name('socials.delete');
            Route::post('/', [SocialsController::class, 'store'])->name('socials.store');
            Route::PUT('/', [SocialsController::class, 'update'])->name('socials.update');
        }
    );
    /**
     * Route for Sizes
     */
    Route::group(
        ['prefix' => '/size'],
        function () {
            Route::get('/', [SizeController::class, 'size'])->name('size');
            Route::delete('/', [SizeController::class, 'delete'])->name('size.delete');
            Route::post('/', [SizeController::class, 'store'])->name('size.store');
            Route::PUT('/', [SizeController::class, 'update'])->name('size.update');
        }
    );
    /**
     * Route for Colors
     */
    Route::group(
        ['prefix' => '/colors'],
        function () {
            Route::get('/', [ColorController::class, 'colors'])->name('colors');
            Route::delete('/', [ColorController::class, 'delete'])->name('colors.delete');
            Route::post('/', [ColorController::class, 'store'])->name('colors.store');
            Route::PUT('/', [ColorController::class, 'update'])->name('colors.update');
        }
    );
    /**
     * Route for addtions
     */
    Route::group(
        ['prefix' => '/addtions'],
        function () {
            Route::get('/', [AddtionsController::class, 'addtions'])->name('addtions');
            Route::get('/addtionsDetials/{id}', [AddtionsController::class, 'addtionsDetials'])->name('addtionsDetials');
            Route::delete('/', [AddtionsController::class, 'delete'])->name('addtions.delete');
            Route::post('/', [AddtionsController::class, 'store'])->name('addtions.store');
            Route::PUT('/', [AddtionsController::class, 'update'])->name('addtions.update');
            Route::delete('/addtionsDetials', [AddtionsController::class, 'deleteAddition'])->name('addtions.deleteAddition');
            Route::post('/addtionsDetials', [AddtionsController::class, 'storeAddition'])->name('addtions.storeAddition');
            Route::PUT('/addtionsDetials', [AddtionsController::class, 'updateAddition'])->name('addtions.deleteAddition');
        }
    );

    /**
     * Route for Orders Admin
     */
    Route::group(
        ['prefix' => '/orders'],
        function () {
            Route::get('/{id}', [OrderController::class, 'orders'])->name('orders');
            Route::get('/accepetOrder/{id}', [OrderController::class, 'accepetOrder'])->name('accepetOrder');
            Route::post('/rejecetOrder', [OrderController::class, 'rejecetOrder'])->name('rejecetOrder');
            Route::delete('/', [OrderController::class, 'delete'])->name('orders.delete');
            Route::get('/orderDetials/{id}', [DelivaryController::class, 'orderDetials'])->name('orderDetials');
        }
    );

    /**
     * Route for Orders Admin
     */
    Route::group(
        ['prefix' => '/packages', 'middleware' => 'can:packages'],
        function () {
            Route::get('/{id}', [PackageController::class, 'packages'])->name('packages');
            Route::get('/accepetPackage/{id}', [PackageController::class, 'accepetPackage'])->name('accepetPackage');
            Route::get('/packageDetials/{id}', [PackageController::class, 'packageData'])->name('packageData');
            Route::post('/rejecetPackage', [PackageController::class, 'rejecetPackage'])->name('rejecetPackage');
            Route::delete('/', [PackageController::class, 'delete'])->name('packages.delete');
            Route::post('/packageDetials', [PackageController::class, 'packageDetials'])->name('packageDetials');
            Route::post('/addDelivary', [PackageController::class, 'addDelivary'])->name('addDelivarypackage');
        }
    );

    /**
     * Route for Orders Seller
     */
    Route::group(
        ['prefix' => '/ordersSeller'],
        function () {
            Route::get('/{id}', [orderSellerController::class, 'orders'])->name('ordersSeller');
            Route::get('/accepetOrder/{id}', [orderSellerController::class, 'accepetOrder'])->name('accepetordersSeller');
            Route::post('/rejecetOrder', [orderSellerController::class, 'rejecetOrder'])->name('rejecetordersSeller');
            Route::delete('/', [orderSellerController::class, 'delete'])->name('ordersSeller.delete');
            Route::get('/orderDetials/{id}', [orderSellerController::class, 'orderDetials'])->name('ordersSellerDetials');
        }
    );

    /**
     * Route for Bank
     */
    Route::group(
        ['prefix' => '/bank', 'middleware' => 'can:bank'],
        function () {
            Route::get('/', [BankController::class, 'bank'])->name('bank');
            Route::delete('/', [BankController::class, 'delete'])->name('bank.delete');
            Route::get('/Transferredcommissions', [BankController::class, 'Transferredcommissions'])->name('Transferredcommissions');
            Route::delete('/TransferredcommissionsDelete', [BankController::class, 'TransferredcommissionsDelete'])->name('TransferredcommissionsDelete');
            Route::post('/', [BankController::class, 'store'])->name('bank.store');
            Route::PUT('/', [BankController::class, 'update'])->name('bank.update');
        }
    );

    /**
     * Route for Messages
     */
    Route::group(
        ['prefix' => '/messages', 'middleware' => 'can:message'],
        function () {
            Route::get('/user', [ContactController::class, 'user'])->name('user');
            Route::get('/cacher', [ContactController::class, 'cacher'])->name('cacherMessages');
            Route::get('/delivery', [ContactController::class, 'delivery'])->name('deliveryMessage');
            Route::get('/showmessage/{id}', [ContactController::class, 'showmessage'])->name('showmessage');
            Route::delete('/', [ContactController::class, 'delete'])->name('message.delete');
        }
    );
    /**
     * Route for Contact
     */
    Route::group(
        ['prefix' => '/contactMessage', 'middleware' => 'can:contactMessage'],
        function () {
            Route::get('/{id}', [MessagesController::class, 'contactMessage'])->name('contactMessage');
            Route::delete('/', [MessagesController::class, 'contactMessageDelete'])->name('contactMessage.delete');
        }
    );

    /**
     * Route for complains
     */
    Route::group(
        ['prefix' => '/complains', 'middleware' => 'can:complains'],
        function () {
            Route::get('/{id}', [ComplainController::class, 'complains'])->name('complains');
            Route::delete('/', [ComplainController::class, 'delete'])->name('complains.delete');
        }
    );
    /**
     * Route for Comments
     */
    Route::group(
        ['prefix' => '/comments', 'middleware' => 'can:comments'],
        function () {
            Route::get('/', [CommentController::class, 'comments'])->name('comments');
            Route::get('/commentsMembers', [CommentController::class, 'commentsMembers'])->name('commentsMembers');
            Route::get('/view/{id}', [CommentController::class, 'adsCommentes'])->name('adsCommentes');
            Route::get('/userCommentes/{id}', [CommentController::class, 'userCommentes'])->name('userCommentes');
            Route::delete('/', [CommentController::class, 'delete'])->name('comments.delete');
        }
    );
    /**
     * Route for follow
     */
    Route::group(
        ['prefix' => '/follow', 'middleware' => 'can:follow'],
        function () {
            Route::get('/followAds', [FollowController::class, 'followAds'])->name('followAds');
            Route::get('/followMember', [FollowController::class, 'followMember'])->name('followMember');
            Route::delete('/', [FollowController::class, 'delete'])->name('follow.delete');
            Route::post('/adsDetials', [FollowController::class, 'adsDetials'])->name('adsDetials');
        }
    );
    /**
     * Route for favourie
     */
    Route::group(
        ['prefix' => '/favourie', 'middleware' => 'can:favourie'],
        function () {
            Route::get('/', [FavouriteController::class, 'favourie'])->name('favourie');
            Route::delete('/', [FavouriteController::class, 'delete'])->name('favourie.delete');
        }
    );

    /**
     * Route for notifications
     */
    Route::group(
        ['prefix' => '/notifications', 'middleware' => 'can:notifications'],
        function () {
            Route::get('/', [NotificationsController::class, 'notifications'])->name('notifications');
            Route::post('/getData', [NotificationsController::class, 'getData'])->name('getData');
            Route::post('/', [NotificationsController::class, 'store'])->name('notifications.store');
            Route::delete('/', [NotificationsController::class, 'delete'])->name('notifications.delete');
        }
    );
    /**
     * Route for settings
     */
    Route::group(
        ['prefix' => '/settings'],
        function () {
            Route::get('/', [SettingController::class, 'settings'])->name('settings');
            Route::post('/firebaseUpdate', [SettingController::class, 'firebaseUpdate'])->name('firebaseUpdate');
            Route::post('/smsUpdate', [SettingController::class, 'smsUpdate'])->name('smsUpdate');
            Route::post('/nameandLogo', [SettingController::class, 'nameandLogo'])->name('nameandLogo');
            Route::post('/points', [SettingController::class, 'points'])->name('points');
            Route::post('/homw_desc', [SettingController::class, 'homw_desc'])->name('homw_desc');
            Route::post('/addition_value', [SettingController::class, 'addition_value'])->name('addition_value');
        }
    );

    /**
     * Route for wallet
     */
    Route::group(
        ['prefix' => '/wallet'],
        function () {
            Route::get('/{id}', [WalletController::class, 'wallet'])->name('wallet');
            Route::get('/balance/{id}', [WalletController::class, 'balance'])->name('balance');
            Route::post('/', [WalletController::class, 'addtransactions'])->name('addtransactions');
            Route::post('/addWallet', [WalletController::class, 'addWallet'])->name('addWallet');
            Route::post('/accapetBalance', [WalletController::class, 'accapetBalance'])->name('accapetBalance');
            Route::get('/rejecetBalance/{id}', [WalletController::class, 'rejecetBalance'])->name('rejecetBalance');
        }
    );
    Route::get('/balancesRequest', [WalletController::class, 'balancesRequest'])->name('balancesRequest');

    /**
     * Route for coupon
     */
    Route::group(
        ['prefix' => '/coupon'],
        function () {
            Route::get('/', [CouponController::class, 'coupon'])->name('coupon');
            Route::get('/addCoupon', [CouponController::class, 'addCoupon'])->name('addCoupon');
            Route::delete('/', [CouponController::class, 'delete'])->name('coupon.delete');
            Route::post('/', [CouponController::class, 'store'])->name('coupon.store');
            Route::PUT('/', [CouponController::class, 'update'])->name('coupon.update');
        }
    );

    /**
     * Route for offers
     */
    Route::group(
        ['prefix' => '/offers', 'middleware' => 'can:offers'],
        function () {
            Route::get('/', [OfferController::class, 'offers'])->name('offers');
            Route::delete('/', [OfferController::class, 'delete'])->name('offers.delete');
            Route::post('/', [OfferController::class, 'store'])->name('offers.store');
            Route::PUT('/', [OfferController::class, 'update'])->name('offers.update');
            Route::get('/accepetOffer/{id}', [OfferController::class, 'accepetOffer'])->name('accepetOffer');
            Route::get('/rejecetOffer/{id}', [OfferController::class, 'rejecetOffer'])->name('rejecetOffer');
            Route::post('/getProducts', [OfferController::class, 'getProducts'])->name('getProducts');
        }
    );

    /**
     * Route for financial_reports
     */
    Route::group(
        ['prefix' => '/', 'middleware' => 'can:financial_reports'],
        function () {
            Route::get('/countOrders', [financialReportsController::class, 'countOrders'])->name('countOrders');
            Route::post('/countOrders/productReport', [financialReportsController::class, 'productReport'])->name('productReport');
            Route::get('/countOrdersClient', [financialReportsController::class, 'countOrdersClient'])->name('countOrdersClient');
            Route::get('/countOrdersStore', [financialReportsController::class, 'countOrdersStore'])->name('countOrdersStore');
            Route::get('/countOrdersResturant', [financialReportsController::class, 'countOrdersResturant'])->name('countOrdersResturant');
            Route::get('/resturantProducts/{id}', [financialReportsController::class, 'resturantProducts'])->name('resturantProducts');
            Route::get('/countOrdersDelivary', [financialReportsController::class, 'countOrdersDelivary'])->name('countOrdersDelivary');
            Route::get('/countOrdersCacher', [financialReportsController::class, 'countOrdersCacher'])->name('countOrdersCacher');
        }
    );

    /**
     * Route for reports
     */
    Route::group(
        ['prefix' => '/'],
        function () {
            Route::get('/countOrdersSellers', [financialReportsController::class, 'countOrdersSellers'])->name('countOrdersSellers');
            Route::get('/countOrdersClientSellers', [financialReportsController::class, 'countOrdersClientSellers'])->name('countOrdersClientSellers');
            Route::get('/countOrdersCacherSeller', [financialReportsController::class, 'countOrdersCacherSeller'])->name('countOrdersCacherSeller');
            Route::post('/filterResturants', [financialReportsController::class, 'filterResturants'])->name('filterResturants');
            Route::post('/filterStore', [financialReportsController::class, 'filterStore'])->name('filterStore');
            Route::post('/filterClient', [financialReportsController::class, 'filterClient'])->name('filterClient');
        }
    );
    Route::group(
        ['prefix' => '/date'],
        function () {
            Route::get('/', [DateController::class,'index'])->name('date');
            Route::post('/create', [DateController::class,'store'])->name('date.store');
            Route::put('/update', [DateController::class,'update'])->name('date.update');
            Route::put('/show', [DateController::class,'show'])->name('date.show');
            Route::put('/hide', [DateController::class,'hide'])->name('date.hide');
            Route::delete('/remove', [DateController::class,'delete'])->name('date.delete');
        }
    );
});

Route::get('/payment', Payments::class)->name('payments');
Route::get('/payment/save', Payments::class)->name('payments.save');
