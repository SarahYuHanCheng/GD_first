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
$tt='www';
Route::post('register', 'UserController@create');


Route::group(['middleware' => ['auth.token:'.$tt]], function(){
    Route::get('logout', 'UserController@logout');
    Route::post('login', 'UserController@login');
    Route::resource('accounts', 'AccountController')->only(['index', 'store', 'show']);
    Route::resource('transactions', 'TransactionController')->only(['index', 'store', 'show']);
});







Route::delete('products/{product}/favorite', 'ProductController@disfavor')->name('products.disfavor');
Route::get('products/favorites', 'ProductController@favorites')->name('products.favorites');


// Route::get('/PayPalAuthorize', 'PaymentsController@authorizePayPalOrder');
// Route::get('/user', function (Request $request) {
//     $out = new \Symfony\Component\Console\Output\ConsoleOutput();
//             $out->writeln("apiin");
//     return $request->user();
// });