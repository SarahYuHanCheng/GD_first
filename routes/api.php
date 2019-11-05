<?php

use Illuminate\Http\Request;

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
Route::post('register', 'UserController@store');


Route::group(['middleware' => ['auth.user:merchant']], function(){
    Route::get('merchant/logout', 'UserController@logout');
    Route::post('merchant/login', 'UserController@login');
    Route::resource('merchant/shop', 'ShopController')->only(['index', 'store', 'show','destroy']);
    Route::resource('merchant/shopmagic', 'ShopMagicController')->only(['index', 'store', 'show']);
    Route::resource('merchant/magic', 'MagicController')->only(['index', 'store', 'show']);
});
Route::group(['middleware' => ['auth.user:user']], function(){
    Route::get('logout', 'UserController@logout');
    Route::post('login', 'UserController@login');
    Route::resource('shop', 'ShopController')->only(['index', 'show']);
    Route::resource('magic', 'UserMagicController')->only(['index', 'store', 'show']);
});






Route::delete('products/{product}/favorite', 'ProductController@disfavor')->name('products.disfavor');
Route::get('products/favorites', 'ProductController@favorites')->name('products.favorites');


// Route::get('/PayPalAuthorize', 'PaymentsController@authorizePayPalOrder');
// Route::get('/user', function (Request $request) {
//     $out = new \Symfony\Component\Console\Output\ConsoleOutput();
//             $out->writeln("apiin");
//     return $request->user();
// });