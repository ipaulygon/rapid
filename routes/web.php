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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('dashboard', 'HomeController@index');

//Supplier
Route::get('maintenance/supplier', 'SupplierController@index');
Route::post('maintenance/supplier/create', 'SupplierController@create');
Route::post('maintenance/supplier/update', 'SupplierController@update');
Route::post('maintenance/supplier/destroy', 'SupplierController@destroy');

//ProductBrand
Route::get('maintenance/product-brand', 'BrandController@index');
Route::post('maintenance/product-brand/create', 'BrandController@create');
Route::post('maintenance/product-brand/update', 'BrandController@update');
Route::post('maintenance/product-brand/destroy', 'BrandController@destroy');

//ProductUnit
Route::get('maintenance/product-unit', 'UnitController@index');
Route::post('maintenance/product-unit/create', 'UnitController@create');
Route::post('maintenance/product-unit/update', 'UnitController@update');
Route::post('maintenance/product-unit/destroy', 'UnitController@destroy');

//ProductType
Route::get('maintenance/product-type', 'ProductTypeController@index');
Route::post('maintenance/product-type/create', 'ProductTypeController@create');
Route::post('maintenance/product-type/update', 'ProductTypeController@update');
Route::post('maintenance/product-type/destroy', 'ProductTypeController@destroy');

//ProductVariance
Route::get('maintenance/product-variance', 'VarianceController@index');
Route::post('maintenance/product-variance/create', 'VarianceController@create');
Route::post('maintenance/product-variance/update', 'VarianceController@update');
Route::post('maintenance/product-variance/destroy', 'VarianceController@destroy');

//Product
Route::get('maintenance/product','ProductController@index');
Route::post('maintenance/product/create','ProductController@create');
Route::post('maintenance/product/update','ProductController@update');
Route::post('maintenance/product/destroy','ProductController@destroy');

//Promo
Route::get('maintenance/promo','PromoController@index');
Route::post('maintenance/promo/create','PromoController@create');
Route::post('maintenance/promo/update','PromoController@update');
Route::post('maintenance/promo/destroy','PromoController@destroy');

//Discount
Route::get('maintenance/discount','DiscountController@index');
Route::post('maintenance/discount/create','DiscountController@create');
Route::post('maintenance/discount/update','DiscountController@update');
Route::post('maintenance/discount/destroy','DiscountController@destroy');

//ServiceCategory
Route::get('maintenance/service-category','ServiceCategoryController@index');
Route::post('maintenance/service-category/create','ServiceCategoryController@create');
Route::post('maintenance/service-category/update','ServiceCategoryController@update');
Route::post('maintenance/service-category/destroy','ServiceCategoryController@destroy');

//Service
Route::get('maintenance/service','ServiceController@index');
Route::post('maintenance/service/create','ServiceController@create');
Route::post('maintenance/service/update','ServiceController@update');
Route::post('maintenance/service/destroy','ServiceController@destroy');

//Inspect
Route::get('maintenance/inspect-type','InspectTypeController@index');
Route::post('maintenance/inspect-type/create','InspectTypeController@create');
Route::post('maintenance/inspect-type/update','InspectTypeController@update');
Route::post('maintenance/inspect-type/destroy','InspectTypeController@destroy');

Route::get('maintenance/inspect-item','InspectItemController@index');
Route::post('maintenance/inspect-item/create','InspectItemController@create');
Route::post('maintenance/inspect-item/update','InspectItemController@update');
Route::post('maintenance/inspect-item/destroy','InspectItemController@destroy');

//Tech
Route::get('maintenance/technician','TechController@index');
Route::post('maintenance/technician/create','TechController@create');
Route::post('maintenance/technician/update','TechController@update');
Route::post('maintenance/technician/destroy','TechController@destroy');

//Inspect
Route::get('transaction/inspect','InspectController@index');
Route::post('transaction/inspect/create','InspectController@create');
Route::post('transaction/inspect/update','InspectController@update');
Route::post('transaction/inspect/destroy','InspectController@destroy');