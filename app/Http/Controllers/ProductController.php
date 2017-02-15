<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\ProductType;
use App\Brand;
use App\Variance;
use App\ProductVariance;
use App\TypeVariance;

use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$prod_max = \DB::table('product')->count('productId');
        $prod_max = $prod_max + 1;
        $newId = 'PROD'.str_pad($prod_max, 4, '0', STR_PAD_LEFT); 
    	$type = ProductType::get();
        $brand = Brand::get();
        $variance = Variance::with('unit')->orderBy('varianceSize')->get();
        $product = Product::with('types.variance.variance.unit')->with('brand')->with('variance.variance.unit')->get();
        $tv = TypeVariance::with('type')->with('variance.unit')->get();
        //$pv = ProductVariance::with('product')->with('variance')->orderBy('pvVarianceId')->get();
        return view('Maintenance.Inventory.product',compact('product','type','brand','variance','tv','newId'));
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
        if($variances!=null || $variances!=''){
            $prices = $request->input('cost');
            $x = 0;
            foreach($variances as $var) {
                $pv = ProductVariance::create(array(
                    'pvProductId' => $request->input('productId'),
                    'pvVarianceId' => $var,
                    'pvCost' => $prices[$x],
                    'pvIsActive' => 1
                    ));
                $pv->save();
                $x++;
            }
        }
        \Session::flash('flash_message','Product successfully added.');
        return redirect('maintenance/product');
    }

    public function update(Request $request){
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
            $product = Product::find($request->input('editProductId'));
            $product->productBrandId = trim($request->input('editProductBrandId'));
            $product->productTypeId = trim($request->input('editProductTypeId'));
            $product->productName = trim($request->input('editProductName'));
            $product->productDesc = trim($request->input('editProductDesc'));
            $product->save();
            $affectedRows = ProductVariance::where('pvProductId', '=', $request->input('editProductId'))->update(['pvIsActive' => 0]);
            $variance = $request->input('editVariance');
            $prodId = $request->input('editProductId');
            $variances = explode(',', $variance);
            $prices = $request->input('editCost');
            $x = 0;

            /*for($y = 0; $y < count($prices) ; $y++ ){
                echo $prices[$y];
            }
            die();*/

            foreach($variances as $var) {
                $pv = ProductVariance::create(array(
                    'pvProductId' => $request->input('editProductId'),
                    'pvVarianceId' => $var,
                    'pvCost' => $prices[$x],
                    'pvIsActive' => 1
                    ));
                $pv->save();
                $x++;
            }
            \Session::flash('flash_message','Product successfully updated.');
        }else{
            \Session::flash('error_message','Product already exists. Update failed.');
        }
        return redirect('maintenance/product');
    }

    public function destroy(Request $request){
        $id = $request->input('delProductId');
        $product = Product::find($request->input('delProductId'));
        $product->productIsActive = 0;
        $product->save();
        \Session::flash('flash_message','Product successfully deactivated.');
        return redirect('maintenance/product');
    }

    public function type(Request $request){
        $typeId = $request->input('id');
        $data = TypeVariance::with('variance.unit')->where('tvTypeId','=',$typeId)->where('tvIsActive','=',1)->get();
        return \Response::json(array('data'=>$data));
    }
}
