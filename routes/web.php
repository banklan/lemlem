<?php
use App\Http\Controllers\OrderController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/order', function () {
    return view('welcome');
});

Route::get('/make_orders', 'OrderController@index')->name('make-orders');
Route::get('/cuisine/{id}/{cuisine}', 'OrderController@index');
Route::get('/outlets/{id}/{cuisine}', 'OrderController@index');
Route::get('/images/assets/cuisines/{picture}', 'OrderController@index');
Route::get('/images/assets/outlets/{picture}', 'OrderController@index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/my_orders', 'HomeController@index');
Route::get('/my_orders/{id}', 'HomeController@index');
Route::get('/checkout', 'HomeController@index');

// api routes
Route::get('/get_cities', 'CityController@getCities');
Route::get('/fetch_outlets/{id}', 'CityController@fetchOutlets');
Route::get('/fetch_meals/{id}', 'CuisinesController@fetchMeals');
Route::get('/fetch_categories', 'CuisinesController@fetchCats');
Route::get('/get_carousel_imgs', 'CuisinesController@fetchCarouselImgs');
Route::get('/fetch_alloutlets', 'OutletsController@fetchAllOutlets');

Route::get('/fetch_allcuisines', 'CuisinesController@fetchAll');
Route::get('/fetch_popcuisines', 'CuisinesController@fetchPopCuisines');
Route::post('/search_cuisine', 'CuisinesController@search');
Route::get('/fetch_cuisinebyid/{id}', 'CuisinesController@getCuisineById');
Route::get('/fetch_similarcuisine/{id}', 'CuisinesController@fetchSimilarCuis');
Route::get('/fetch_mealsfromsameoutlet/{id}', 'CuisinesController@fetchCuisFromSameIutlets');
Route::get('/fetch_outletbyid/{id}', 'OutletsController@fetchOutlet');

Route::get('/calc', 'OrderController@calc');

Route::post('/post_orders', 'OrderController@send');
Route::post('/send_order_rcvd_mail', 'OrderController@sendOrderRcvdMail');
Route::get('/fetch_myorders', 'OrderController@fetchMyOrders');
Route::get('/fetch_order/{order}', 'OrderController@fetchSingleOrder');
Route::get('/fetch_ordersummary/{order}', 'OrderController@fetchOrderSummary');
Route::get('/fetch_ordersummaries_foruser', 'OrderController@fetchOrderSummaryForUser');

Route::get('/check_user_loc', 'HomeController@checkUserLoc');

Route::get('/get_locations/{id}', 'CityController@fetchLocations');
Route::post('/save_userlocation', 'HomeController@saveUserLocation');
Route::get('/get_user_loc', 'CityController@fetchUserLoc');

// Route::post('/send_cuis_review/{order}', 'ReviewController@sendCuisineReview');
// Route::get('/check_if_cuisinereviewed/{order}', 'ReviewController@checkCuisReview');
Route::post('/send_valetreview/{order}', 'ReviewController@sendValetReview');
Route::post('/send_order_review/{order}', 'ReviewController@sendOrderReview');
Route::get('/fetch_cuisine_reviews/{cuisine}', 'ReviewController@fetchCuisReviews');
Route::get('/fetch_outletratings/{id}', 'ReviewController@fetchRatings');
Route::get('/show_review_modal', 'ReviewController@showReviewModal');


//admin routes
Route::prefix('admin')->group(function(){
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    // Route::post('/login', 'Auth\AdminLoginController@')->name('admin.password.request');
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    
    Route::get('/', 'AdminController@index')->name('admin.home');
    Route::get('/users/{any}', 'AdminController@index');
    Route::get('/users/admin/{any}', 'AdminController@index');
    Route::get('/users/bearer/{any}', 'AdminController@index');
    Route::get('/users/client_user/{any}', 'AdminController@index');
    Route::get('/outlets', 'AdminController@index');
    Route::get('/outlet/{any}', 'AdminController@index');
    Route::get('/cities', 'AdminController@index');
    Route::get('/locations', 'AdminController@index');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

});


//bearer routes
Route::prefix('bearer')->group(function(){
    Route::get('/login', 'Auth\BearerLoginController@showLoginForm')->name('bearer.login');
    Route::post('/login', 'Auth\BearerLoginController@login')->name('bearer.login.submit');
    // Route::post('/login', 'Auth\BearerLoginController@')->name('bearer.password.request');
    Route::post('/password/email', 'Auth\BearerForgotPasswordController@sendResetLinkEmail')->name('bearer.password.email');
    Route::get('/password/reset', 'Auth\BearerForgotPasswordController@showLinkRequestForm')->name('bearer.password.request');
    Route::post('/password/reset', 'Auth\BearerResetPasswordController@reset');
    Route::get('/password/reset/{token}', 'Auth\BearerResetPasswordController@showResetForm')->name('bearer.password.reset');

    Route::get('/', 'BearerController@index')->name('bearer.home');
    Route::post('/logout', 'Auth\BearerLoginController@logout')->name('bearer.logout');
});


//admin api calls
Route::get('/admin_get_alladmins', 'AdminController@getAllAdmins');
Route::get('/admin_getadmin/{id}', 'AdminController@getAdmin');
Route::post('/admin_disableadmin/{id}', 'AdminController@disableAdmin');
Route::post('/admin_enableadmin/{id}', 'AdminController@enableAdmin');
Route::post('/admin_updateadmin/{id}', 'AdminController@updateAdminDetails');
Route::post('/admin_changeadminpswd/{id}', 'AdminController@updateAdminPswd');
Route::post('/admin_createnewadmin', 'AdminController@createNewAdmin');
Route::post('/admin_deleteadmin/{id}', 'AdminController@delAdmin');
Route::post('/admin_updateadmin/{id}', 'AdminController@updateAdmin');
Route::get('/admin_get_allbearers', 'AdminController@getAllBearers');
Route::post('/admin_createnewbearer', 'AdminController@createNewBearer');
Route::post('/admin_deletebearer/{id}', 'AdminController@deleteBearer');
Route::post('/admin_updatebearer/{id}', 'AdminController@updateBearerDetails');
Route::get('/admin_getbearer/{id}', 'AdminController@getBearer');
Route::post('/admin_disablebearer/{id}', 'AdminController@disableBearer');
Route::post('/admin_enablebearer/{id}', 'AdminController@enableBearer');
Route::post('/admin_updatebearer/{id}', 'AdminController@updateBearer');
Route::post('/admin_changebearerpswd/{id}', 'AdminController@updateBearerPswd');
Route::get('/admin_get_allusers', 'AdminController@getAllUsers');
Route::post('/admin_createnewuser', 'AdminController@createNewUser');
Route::get('/admin_getalllocations', 'AdminController@getAllLocations');
Route::post('/admin_deleteuser/{id}', 'AdminController@delClientUser');
Route::post('/admin_updateuser/{id}', 'AdminController@updateClientUser');
Route::get('/admin_getuser/{id}', 'AdminController@getClientUser');
Route::post('/admin_disableuser/{id}', 'AdminController@disableUser');
Route::post('/admin_enableuser/{id}', 'AdminController@enableUser');
Route::post('/admin_changeuserpswd/{id}', 'AdminController@changeUserPswd');
Route::get('/admin_getalloutlets', 'AdminController@getAllOutlets');
Route::get('/admin_getcities', 'AdminController@getAllCities');
Route::get('/admin_getlocations_fromcity/{id}', 'AdminController@getLocationFromCity');
Route::post('/admin_createnewoutlet', 'AdminController@createNewOutlet');
Route::post('/admin_deleteoutlet/{id}', 'AdminController@delOutlet');
Route::get('/admin_getalllocsincity/{id}', 'AdminController@getLocsInCity');
Route::post('/admin_updateoutlet/{id}', 'AdminController@updateOutlet');
Route::get('/admin_getoutlet/{id}', 'AdminController@getOutlet');
Route::post('/admin_updaterestaurantlogo/{id}', 'AdminController@updateOutletLogo');
Route::post('/admin_createnewcity', 'AdminController@createCity');
Route::post('/admin_updatecity/{id}', 'AdminController@updateCity');
Route::post('/admin_deletecity/{id}', 'AdminController@deleteCity');
Route::get('/admin_getalllocs', 'AdminController@getAllLocs');
Route::post('/admin_createnewLocation', 'AdminController@createLocation');
Route::post('/admin_deletelocation/{id}', 'AdminController@deleteLocation');
Route::post('/admin_updatelocation/{id}', 'AdminController@updateLocation');


