<?php

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

Route::middleware('auth:sanctum')->group(function() 
{
   
   Route::get('fetchcustomerdetails','App\Http\Controllers\customercontroller@fetchauthcustomerdetails');
    Route::post('addtocart/{item_id}','App\Http\Controllers\customercontroller@addtocart');
    Route::post('quantityaddtocart/{item_id}','App\Http\Controllers\customercontroller@incrementCartQuantity');
    Route::post('decrementCartQuantity/{item_id}','App\Http\Controllers\customercontroller@decrementCartQuantity');
    
   
    Route::get('displayusercart','App\Http\Controllers\customercontroller@displaycartofuser');
    Route::delete('deletecart/{cart_id}','App\Http\Controllers\customercontroller@deletecartdata');
    Route::post('signout','App\Http\Controllers\customercontroller@signout');
    Route::post('updatecustomerdata','App\Http\Controllers\customercontroller@updatecustomerdata');
    Route::get('checkoutpage','App\Http\Controllers\customercontroller@checkoutpage');
     Route::post('paymentpage','App\Http\Controllers\customercontroller@paymentpage');
     Route::get('getPayments','App\Http\Controllers\customercontroller@getPayments');

     Route::post('saveOrderDetails','App\Http\Controllers\customercontroller@saveOrderDetails');
     
    
   



});

Route::post('customerreg','App\Http\Controllers\customercontroller@customeregistration');
Route::post('customerlogin','App\Http\Controllers\customercontroller@customerlogin');
Route::post('categinsertion','App\Http\Controllers\admincontroller@categoryinsertion');
Route::get('fetchallproducts','App\Http\Controllers\admincontroller@fetchallproducts');
Route::post('fooditeminsertion','App\Http\Controllers\admincontroller@fooditem_insertion');
 Route::get('fetchallcategory','App\Http\Controllers\customercontroller@fetchcategory');
    Route::get('fetchproductofcategory/{categ_id}','App\Http\Controllers\customercontroller@fetchproductunder_category');
   
    Route::get('categdisplay','App\Http\Controllers\admincontroller@categorydisplay');

   Route::get('individualproductdisplay/{prod_id}','App\Http\Controllers\customercontroller@productdisplaymainpage');
