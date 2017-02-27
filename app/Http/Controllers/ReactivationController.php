<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Discount;
use App\InspectItem;
use App\InspectType;
use App\Package;
use App\Product;
use App\ProductType;
use App\Promo;
use App\Service;
use App\ServiceCategory;
use App\Supplier;
use App\Technician;
use App\Unit;
use App\Variance;

class ReactivationController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$brand = Brand::get();
    	$discount = Discount::get();
    	$inspect_item = InspectItem::get();
    	$inspect_type = InspectType::get();
    	$package = Package::get();
    	$product = Product::get();
    	$product_type = ProductType::get();
    	$promo = Promo::get();
    	$service = Service::get();
    	$service_category = ServiceCategory::get();
    	$supplier = Supplier::get();
    	$technician = Technician::get();
    	$unit = Unit::get();
    	$variance = Variance::get();
    	return view('Utilities.data-reactivation',compact('brand','discount','inspect_item','inspect_type','package','product','product_type','promo','service','service_category','supplier','technician','unit','variance'));
    }

    public function supplier(Request $request){
    	$id = $request->input('supplierId');
    	$supplier = Supplier::find($id);
        $supplier->supplierIsActive = 1;
        $supplier->save();
        \Session::flash('flash_message','Supplier successfully reactivated.');
        return redirect('utilities/data-reactivation');
    }

    public function brand(Request $request){
    	$id = $request->input('brandId');
    	$brand = Brand::find($id);
        $brand->brandIsActive = 1;
        $brand->save();
        \Session::flash('flash_message','Brand successfully reactivated.');
        return redirect('utilities/data-reactivation');
    }

    public function producttype(Request $request){
    	$id = $request->input('productTypeId');
    	$productType = ProductType::find($id);
        $productType->productTypeIsActive = 1;
        $productType->save();
        \Session::flash('flash_message','Product type successfully reactivated.');
        return redirect('utilities/data-reactivation');
    }

    public function unit(Request $request){
    	$id = $request->input('unitId');
    	$unit = Unit::find($id);
        $unit->unitIsActive = 1;
        $unit->save();
        \Session::flash('flash_message','Unit successfully reactivated.');
        return redirect('utilities/data-reactivation');
    }

    public function variance(Request $request){
    	$id = $request->input('varianceId');
    	$variance = Variance::find($id);
        $variance->varianceIsActive = 1;
        $variance->save();
        \Session::flash('flash_message','Variance successfully reactivated.');
        return redirect('utilities/data-reactivation');
    }

    public function product(Request $request){
    	$id = $request->input('productId');
    	$product = Product::find($id);
        $product->productIsActive = 1;
        $product->save();
        \Session::flash('flash_message','Product successfully reactivated.');
        return redirect('utilities/data-reactivation');
    }
}
