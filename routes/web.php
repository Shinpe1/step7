<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ImageController;

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


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/products', 'ProductsController@index')->name('products');

Route::get('/create', 'ProductsController@create')->name('products.create');

Route::post('/store', 'ProductsController@store')->name('products.store');

Route::get('/show/{id}', 'ProductsController@show')->name('products.show');

Route::get('/edit/{id}', 'ProductsController@edit')->name('products.edit');

Route::post('/update/{id}', 'ProductsController@update')->name('products.update');

Route::post('/destroy{id}', 'ProductsController@destroy')->name('products.destroy');

Route::post('/upload', 'ProductsController@upload')->name('products.upload');

Route::post('product/store', 'ProductsController@store')->name('back_product_store');
