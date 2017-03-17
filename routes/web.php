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
Route::get('maintenance/product/form-create','ProductController@createForm');
Route::post('maintenance/product/create','ProductController@create');
Route::post('maintenance/product/update','ProductController@update');
Route::post('maintenance/product/destroy','ProductController@destroy');
Route::post('maintenance/product/type','ProductController@type');
Route::get('maintenance/product/view/{id}','ProductController@view');

//Promo
Route::get('maintenance/promo','PromoController@index');
Route::get('maintenance/promo/form-create','PromoController@createForm');
Route::post('maintenance/promo/create','PromoController@create');
Route::post('maintenance/promo/update','PromoController@update');
Route::post('maintenance/promo/destroy','PromoController@destroy');
Route::get('maintenance/promo/view/{id}','PromoController@view');

//Package
Route::get('maintenance/package','PackageController@index');
Route::get('maintenance/package/form-create','PackageController@createForm');
Route::post('maintenance/package/create','PackageController@create');
Route::post('maintenance/package/update','PackageController@update');
Route::post('maintenance/package/destroy','PackageController@destroy');
Route::get('maintenance/package/view/{id}','PackageController@view');

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


//Utilities
Route::get('utilities/data-reactivation','ReactivationController@index');
Route::post('utilities/data-reactivation/supplier','ReactivationController@supplier');
Route::post('utilities/data-reactivation/brand','ReactivationController@brand');
Route::post('utilities/data-reactivation/product-type','ReactivationController@producttype');
Route::post('utilities/data-reactivation/unit','ReactivationController@unit');
Route::post('utilities/data-reactivation/variance','ReactivationController@variance');
Route::post('utilities/data-reactivation/product','ReactivationController@product');
Route::post('utilities/data-reactivation/service-category','ReactivationController@category');
Route::post('utilities/data-reactivation/service','ReactivationController@service');
Route::post('utilities/data-reactivation/inspect-type','ReactivationController@inspecttype');
Route::post('utilities/data-reactivation/inspect-item','ReactivationController@inspectitem');
Route::post('utilities/data-reactivation/package','ReactivationController@package');
Route::post('utilities/data-reactivation/promo','ReactivationController@promo');
Route::post('utilities/data-reactivation/discount','ReactivationController@discount');
Route::post('utilities/data-reactivation/tech','ReactivationController@tech');

//Transaction
//order-supply
Route::get('transaction/order-supply','OrderSupplyController@index');
Route::get('transaction/order-supply-form','OrderSupplyController@createForm');
Route::post('transaction/order-supply/create','OrderSupplyController@create');
Route::get('transaction/order-supply-form/{id}','OrderSupplyController@updateForm');
Route::post('transaction/order-supply/update','OrderSupplyController@update');
Route::get('transaction/order-supply-pdf/{id}','OrderSupplyController@view');
//receive-delivery
Route::get('transaction/receive-delivery','ReceiveDeliveryController@index');
Route::get('transaction/receive-delivery-form','ReceiveDeliveryController@createForm');
Route::post('transaction/receive-delivery/create','ReceiveDeliveryController@create');
Route::post('transaction/receive-delivery/supplier','ReceiveDeliveryController@supplier');
Route::post('transaction/receive-delivery/order','ReceiveDeliveryController@order');
Route::get('transaction/receive-delivery-pdf/{id}','ReceiveDeliveryController@view');
//Inspect
Route::get('transaction/inspect','InspectController@index');
Route::get('transaction/inspect-form','InspectController@createForm');
Route::post('transaction/inspect/create','InspectController@create');
Route::post('transaction/inspect/update','InspectController@update');
Route::post('transaction/inspect/destroy','InspectController@destroy');
//estimate
Route::get('transaction/estimate','RepairController@index');
Route::get('transaction/estimate-form','RepairController@createEstimateForm');
Route::post('transaction/estimate-form/create','RepairController@createEstimate');
//joborder
Route::get('transaction/job','JobController@index');
Route::get('transaction/job-form','JobController@createForm');
Route::post('transaction/job-form/create','JobController@create');
//payment
Route::get('transaction/payment','PaymentController@index');
Route::get('transaction/payment-form','PaymentController@createForm');
Route::post('transaction/payment-form/create','PaymentController@create');

//QUERIES
Route::get('queries','QueriesController@index');