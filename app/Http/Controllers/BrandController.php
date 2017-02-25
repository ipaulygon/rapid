<?php

namespace App\Http\Controllers;
use App\Http\Requests\BrandRequest;
use App\Brand;
use App\Product;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $brand_max = \DB::table('brand')->count('brandId');
        $brand_max = $brand_max + 1;
        $newId = 'BRAND'.str_pad($brand_max, 4, '0', STR_PAD_LEFT); 
    	$brand = Brand::get();
    	return view('Maintenance.Inventory.product_brand',compact('brand','newId'));
    }

    public function create(BrandRequest $request){
        $brand = Brand::create(array(
            'brandId' => $request->input('brandId'),
            'brandName' => trim($request->input('brandName')),
            'brandDesc' => trim($request->input('brandDesc')),
            'brandIsActive' => 1
            ));
        $brand->save();
        \Session::flash('flash_message','Brand successfully added.');
        return redirect('maintenance/product-brand');
    }

    public function update(Request $request){
        $this->validate($request, [
            'editBrandName' => 'required',
        ]);
    	$checkbrands = Brand::all();
        $isAdded = false;
        foreach ($checkbrands as $brand) {
        	if(!strcasecmp($brand->brandId, $request->input('editBrandId')) == 0 
        		&& strcasecmp($brand->brandName, trim($request->input('editBrandName'))) == 0){
        		$isAdded = true;
        	}
        }
        if(!$isAdded){
            $brand = Brand::find($request->input('editBrandId'));
            $brand->brandName = trim($request->input('editBrandName'));
            $brand->brandDesc = trim($request->input('editBrandDesc'));
            $brand->save();
            \Session::flash('flash_message','Brand successfully updated.');
        }else{
            \Session::flash('error_message','Brand already exists. Update failed.');
        }
        return redirect('maintenance/product-brand');
    }

    public function destroy(Request $request){
        $id = $request->input('delBrandId');
        $product_brand = Product::with('brand')->where('productBrandId','=',$id)->where('productIsActive','=',1)->count();
        if($product_brand>0){
            \Session::flash('error_message','Brand is still being used in products. Deactivation failed');
            return redirect('maintenance/product-brand');
        }
        else{
            $brand = Brand::find($id);
            $brand->brandIsActive = 0;
            $brand->save();
            \Session::flash('flash_message','Brand successfully deactivated.');
            return redirect('maintenance/product-brand');
        }
    }
}
