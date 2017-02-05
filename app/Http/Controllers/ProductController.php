<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\ProductType;
use App\Brand;
use App\Variance;
use App\ProductVariance;

use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$ids = \DB::table('product')
            ->select('productId')
            ->orderBy('created_at', 'desc')
            ->orderBy('productId', 'desc')
            ->take(1)
            ->get();
        $id = $ids["0"]->productId;
        $newId = $this->smartCounter($id);
    	$type = ProductType::get();
        $brand = Brand::get();
        $variance = Variance::with('unit')->get();
        $product = Product::with('types')->with('brand')->with('variance.variance.unit')->get();
        //$pv = ProductVariance::with('product')->with('variance')->get();
        return view('Maintenance.Inventory.product',compact('product','type','brand','variance','newId'));
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
        $prices = $request->input('prices');
        $x = 0;
        foreach($variances as $var) {
            $pv = ProductVariance::create(array(
                'pvProductId' => $request->input('productId'),
                'pvVarianceId' => $variances[$x],
                'pvDesc' => '',
                'pvCost' => $prices[$x],
                'pvIsActive' => 1
                ));
            $pv->save();
            $x++;
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
            /*$vars = ProductVariance::where('pvProductId',$request->input('editProductId'));
            $vars->update(['pvIsActive']=>false);*/
            $variance = $request->input('editVariance');
            $variances = explode(',', $variance);
            $prices = $request->input('price');
            $x = 0;
            foreach($variances as $var) {
                $pv = ProductVariance::create(array(
                    'pvProductId' => $request->input('editProductId'),
                    'pvVarianceId' => $variances[$x],
                    'pvDesc' => '',
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
        \Session::flash('flash_message','Product successfully deleted.');
        return redirect('maintenance/product');
    }

    public function smartCounter($id)
    {   
        $lastID = str_split($id);
        $ctr = 0;
        $tempID = "";
        $tempNew = [];
        $newID = "";
        $add = TRUE;
        for($ctr = count($lastID)-1; $ctr >= 0; $ctr--){
            $tempID = $lastID[$ctr];
            if($add){
                if(is_numeric($tempID) || $tempID == '0'){
                    if($tempID == '9'){
                        $tempID = '0';
                        $tempNew[$ctr] = $tempID;
                    }else{
                        $tempID = $tempID + 1;
                        $tempNew[$ctr] = $tempID;
                        $add = FALSE;
                    }
                }else{
                    $tempNew[$ctr] = $tempID;
                }           
            }
            $tempNew[$ctr] = $tempID;   
        }
        
        for($ctr = 0; $ctr < count($lastID); $ctr++){
            $newID = $newID . $tempNew[$ctr];
        }
        return $newID;
    }
}
