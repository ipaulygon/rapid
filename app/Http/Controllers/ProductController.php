<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\ProductType;
use App\Brand;
use App\Variance;
use App\ProductVariance;
use App\TypeVariance;
use App\PackageProduct;
use App\PromoProduct;
use App\ProductCost;

use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$type = ProductType::get();
        $brand = Brand::get();
        $variance = Variance::with('unit')->orderBy('varianceSize')->get();
        $product = Product::with('types.variance.variance.unit')->with('brand')->with('variance.variance.unit')->get();
        return view('Maintenance.Inventory.product',compact('product','type','brand','variance'));
    }

    public function createForm(){
        $prod_max = \DB::table('product')->count('productId');
        $prod_max = $prod_max + 1;
        $newId = 'PROD'.str_pad($prod_max, 4, '0', STR_PAD_LEFT);
        $type = ProductType::get();
        $brand = Brand::get();
        $variance = Variance::with('unit')->orderBy('varianceSize')->get();
        $product = Product::with('types.variance.variance.unit')->with('brand')->with('variance.variance.unit')->get();
        $tv = TypeVariance::with('variance.unit')->get();
        return view('Maintenance.Inventory.product_form',compact('product','type','brand','variance','tv','newId'));
    }

    public function create(ProductRequest $request){
        $product = Product::create(array(
            'productId' => $request->input('productId'),
            'productBrandId' => trim($request->input('productBrandId')),
            'productTypeId' => trim($request->input('productTypeId')),
            'productName' => trim($request->input('productName')),
            'productDesc' => trim($request->input('productDesc')),
            'productIsActive' => 1
            ));
        $product->save();
        $variance = $request->input('variance');
        $variances = explode(',', $variance);
        $prices = $request->input('cost');
        $x = 0;
        if($variance!=null || $variance!=''){
            foreach($variances as $var) {
                $pv = ProductVariance::create(array(
                    'pvProductId' => $request->input('productId'),
                    'pvVarianceId' => $var,
                    'pvCost' => $prices[$x],
                    'pvIsActive' => 1
                    ));
                $pv->save();
                $latest = ProductVariance::orderBy('pvId','desc')->first();
                $prodCost = ProductCost::create(array(
                    'pcId' => $latest->pvId,
                    'pcCost' => $prices[$x],
                ));
                $prodCost->save();
                $x++;
            }
        }
        \Session::flash('flash_message','Product successfully added.');
        return redirect('maintenance/product');
    }

    public function update(Request $request){
        $this->validate($request, [
            'editProductBrandId' => 'required',
            'editProductTypeId' => 'required',
            'editProductName' => 'required',
        ]);
        $checkproducts = Product::all();
        $isAdded = false;
        foreach ($checkproducts as $product) {
            if(!strcasecmp($product->productId, $request->input('editProductId')) == 0 
                && strcasecmp($product->productName, trim($request->input('editProductName'))) == 0
                && strcasecmp($product->productBrandId, trim($request->input('editProductBrandId'))) == 0
                && strcasecmp($product->productTypeId, trim($request->input('editProductTypeId'))) == 0){
                $isAdded = true;
            }
        }
        if(!$isAdded){
            $id = $request->input('editProductId');
            $product = Product::find($id);
            $product->productBrandId = trim($request->input('editProductBrandId'));
            $product->productTypeId = trim($request->input('editProductTypeId'));
            $product->productName = trim($request->input('editProductName'));
            $product->productDesc = trim($request->input('editProductDesc'));
            $product->save();
            $variance = $request->input('editVariance');
            $prodId = $request->input('editProductId');
            $variances = explode(',', $variance);
            $prices = $request->input('costs');
            //$affectedRows = ProductVariance::where('pvProductId', '=', $request->input('editProductId'))->update(['pvIsActive' => 0]);
            $product_variance = ProductVariance::with('product')->where('pvProductId','=',$id)->where('pvIsActive','=',1)->count();
            if($product_variance==0){
                $x = 0;
                if($variance!=null || $variance!=''){
                    foreach($variances as $var) {
                        $pv = ProductVariance::create(array(
                            'pvProductId' => $request->input('editProductId'),
                            'pvVarianceId' => $var,
                            'pvCost' => $prices[$x],
                            'pvIsActive' => 1
                            ));
                        $pv->save();
                        $latest = ProductVariance::orderBy('pvId','desc')->first();
                        $prodCost = ProductCost::create(array(
                            'pcId' => $latest->pvId,
                            'pcCost' => $prices[$x],
                        ));
                        $prodCost->save();
                        $x++;
                    }
                }
            }else{
                $warning = 0;
                $product_variance = ProductVariance::with('product')->where('pvProductId','=',$id)->where('pvIsActive','=',1)->get();
                if($variance!=null || $variance!=''){
                    foreach($product_variance as $pv){
                        $cost = $request->input($pv->pvVarianceId);
                        if($cost!='' || $cost !=null){
                            $prodVar = ProductVariance::where('pvProductId','=',$id)->where('pvVarianceId','=',$pv->pvVarianceId)->where('pvIsActive','=',1)->first();
                            $prodVar->pvCost = $cost;
                            $prodVar->save();
                            $prodCost = ProductCost::create(array(
                                'pcId' => $prodVar->pvId,
                                'pcCost' => $cost,
                            ));
                            $prodCost->save();
                        }
                        else{
                            $promo_product = PromoProduct::where('promoProductId','=',$pv->pvId)->where('promoPIsActive','=',1)->count();
                            $package_product = PackageProduct::where('packageProductId','=',$pv->pvId)->where('packagePIsActive','=',1)->count(); 
                            if($promo_product>0){
                                $warning = 1;
                            }
                            if($package_product>0){
                                $warning = 2;
                            }
                            if($promo_product>0 && $package_product>0){
                                $warning = 3;
                            }
                            if($promo_product==0 && $package_product==0){
                                $prodVar = ProductVariance::where('pvProductId','=',$id)->where('pvVarianceId','=',$pv->pvVarianceId)->where('pvIsActive','=',1)->update(['pvIsActive' => 0]);
                            }
                        }
                        $variances = array_diff($variances,array($pv->pvVarianceId));
                    }
                    foreach($variances as $var) {
                        $pv = ProductVariance::create(array(
                            'pvProductId' => $request->input('editProductId'),
                            'pvVarianceId' => $var,
                            'pvCost' => $request->input($var),
                            'pvIsActive' => 1
                            ));
                        $pv->save();
                        $latest = ProductVariance::orderBy('pvId','desc')->first();
                        $prodCost = ProductCost::create(array(
                            'pcId' => $pv->pvId,
                            'pcCost' => $request->input($var),
                        ));
                        $prodCost->save();
                    }
                }
                else{
                    foreach($product_variance as $pv){
                        $promo_product = PromoProduct::where('promoProductId','=',$pv->pvId)->where('promoPIsActive','=',1)->count();
                        $package_product = PackageProduct::where('packageProductId','=',$pv->pvId)->where('packagePIsActive','=',1)->count(); 
                        if($promo_product>0){
                            $warning = 1;
                        }
                        if($package_product>0){
                            $warning = 2;
                        }
                        if($promo_product>0 && $package_product>0){
                            $warning = 3;
                        }
                        if($promo_product==0 && $package_product==0){
                            $prodVar = ProductVariance::where('pvProductId','=',$id)->where('pvVarianceId','=',$pv->pvVarianceId)->where('pvIsActive','=',1)->update(['pvIsActive' => 0]);
                        }
                    }
                }
            }
            if($warning==0){
                \Session::flash('flash_message','Product successfully updated.');
            }
            if($warning==1){
                \Session::flash('warning_message','Some of the variances were not updated/deactivated because it is used by promos. Product updated');
            }
            if($warning==2){
                \Session::flash('warning_message','Some of the variances were not updated/deactivated because it is used by packages. Product updated');
            }
            if($warning==3){
                \Session::flash('warning_message','Some of the variances were not updated/deactivated because it is used by promos and packages. Product updated');
            }
        }else{
            \Session::flash('error_message','Product already exists. Update failed.');
        }
        return redirect('maintenance/product');
    }

    public function destroy(Request $request){
        $id = $request->input('delProductId');
        $used = 0;
        $product_variance = ProductVariance::where('pvProductId','=',$id)->where('pvIsActive','=',1)->get();
        foreach ($product_variance as $pv) {
            $package = PackageProduct::where('packageProductId','=',$pv->pvId)->where('packagePIsActive','=',1)->count();
            if($package>0){
                \Session::flash('error_message','Product is still being used in packages. Deactivation failed');
                return redirect('maintenance/product');
            }
        }
        foreach ($product_variance as $pv) {
            $promo = PromoProduct::where('promoProductId','=',$pv->pvId)->where('promoPIsActive','=',1)->count();
            if($promo>0){
                \Session::flash('error_message','Product is still being used in promos. Deactivation failed');
                return redirect('maintenance/product');
            }
        }
        $product = Product::find($request->input('delProductId'));
        $product->productIsActive = 0;
        $product->save();
        $affectedRows = ProductVariance::where('pvProductId', '=', $id)->update(['pvIsActive' => 0]);
        \Session::flash('flash_message','Product successfully deactivated.');
        return redirect('maintenance/product');
    }

    public function type(Request $request){
        $typeId = $request->input('id');
        $data = TypeVariance::with('variance.unit')->where('tvTypeId','=',$typeId)->where('tvIsActive','=',1)->get();
        return \Response::json(array('data'=>$data));
    }

    public function view($id){
        $product = Product::with('types.variance.variance.unit')->with('brand')->with('variance.variance.unit')->where('productId','=',$id)->get();
        $type = ProductType::get();
        $brand = Brand::get();
        $variance = Variance::with('unit')->orderBy('varianceSize')->get();
        $tv = TypeVariance::with('variance.unit')->get();
        $pv = ProductVariance::with('variance.unit')->where('pvProductId','=',$id)->get();
        return view('Maintenance.Inventory.product_update',compact('product','type','brand','variance','pv','tv'));
        //return \Response::json(array('$product'=>$product));
    }
}
