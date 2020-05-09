<?php

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

use App\Http\Controllers\FollowsController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;



Auth::routes();

//Items
Route::get('/item','ItemsController@index')->name('item.index');
Route::get('/item/create', 'ItemsController@create')->name('item.create');
Route::get('/item/{item}/edit', 'ItemsController@edit')->name('item.edit');
Route::post('/item', 'ItemsController@store')->name('item.store');
Route::post('/item/{item}', 'ItemsController@update')->name('item.update');

//Purchase
Route::get('/purchase','PurchasesController@index')->name('purchase.index');
Route::get('/purchase/create', 'PurchasesController@create')->name('purchase.create');
Route::get('/purchase/{purchase}/edit', 'PurchasesController@edit')->name('purchase.edit');
Route::post('/purchase', 'PurchasesController@store')->name('purchase.store');
Route::get('/purchase/print/{id}', 'PurchasesController@print_purchase')->name('purchase.print');
Route::post('/purchase/{purchase}', 'PurchasesController@update')->name('purchase.update');
Route::get('/purchase/purchase-no', 'PurchasesController@get_new_purchase_no')->name('get.purchase.no');

//Issue
Route::get('/issue','IssuesController@index')->name('issue.index');
Route::get('/issue/create', 'IssuesController@create')->name('issue.create');
Route::get('/issue/{issue}/edit', 'IssuesController@edit')->name('issue.edit');
Route::post('/issue', 'IssuesController@store')->name('issue.store');
Route::get('/issue/print/{id}', 'IssuesController@print_issue')->name('issue.print');
Route::post('/issue/{issue}', 'IssuesController@update')->name('issue.update');
Route::get('/issue/issue-no', 'IssuesController@get_new_issue_no')->name('get.issue.no');
Route::get('/issue/items-edition/{id}', 'IssuesController@get_items_edition')->name('get.items.edition');





//Suppliers
Route::get('/supplier','SuppliersController@index')->name('supplier.index');
Route::get('/supplier/create', 'SuppliersController@create')->name('supplier.create');
Route::get('/supplier/{supplier}/edit', 'SuppliersController@edit')->name('supplier.edit');
Route::post('/supplier', 'SuppliersController@store')->name('supplier.store');
Route::post('/supplier/{supplier}', 'SuppliersController@update')->name('supplier.update');

//Items Management
Route::get('/stock','StocksController@index')->name('stock.index');
Route::get('/stock/create', 'StocksController@create')->name('stock.create');
Route::get('/stock/{stock}/edit', 'StocksController@edit')->name('stock.edit');
Route::post('/stock', 'StocksController@store')->name('stock.store');
Route::post('/stock/{stock}', 'StocksController@update')->name('stock.update');

//Publishers
Route::get('/publisher','PublishersController@index')->name('publisher.index');
Route::get('/publisher/create', 'PublishersController@create')->name('publisher.create');
Route::get('/publisher/{publisher}/edit', 'PublishersController@edit')->name('publisher.edit');
Route::post('/publisher', 'PublishersController@store')->name('publisher.store');
Route::post('/publisher/{publisher}', 'PublishersController@update')->name('publisher.update');
Route::get('/publisher/{post}', 'PublishersController@show')->name('publisher.show');


//Profile
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/','HomeController@dashboard');
Route::get('/posts','PostsController@index')->name('posts');


Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');

//Post
Route::get('/p/create', 'PostsController@create')->name('p.create');
Route::post('/p', 'PostsController@store')->name('p.store');
Route::get('/p/{post}', 'PostsController@show')->name('p.show');

//Follow User
//Route::post('/follow/{user}',function (){
//    return['success'];
//});
Route::post('/follow/{user}','FollowsController@store');
