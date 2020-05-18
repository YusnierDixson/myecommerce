<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
//Acceder a todas las rutas del controlador rest
Route::resource('productos', 'ProductsController');
Route::resource('in_shopping_carts', 'ProductInShoppingCartsController',[
    "only"=>["store","destroy"]
]);
Route::get('/carrito','ShoppingCartController@show')->name('shopping_cart.show');
Route::get('/carrito/productos','ShoppingCartController@products')->name('shopping_cart.products');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/pagar','PaymentsController@pay')->name('payments.pay');
Route::get('/pagar/completar','PaymentsController@execute')->name('payments.execute');
