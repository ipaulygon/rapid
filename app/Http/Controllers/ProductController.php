<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\VarianceRequest;
use App\Product;
use App\ProductType;
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
    	$product_type = ProductType::get();
        $brand = Brand::get();
        $product = Product::with('types')->with('brand')->get();
        return view('Maintenance.Inventory.product',compact('product','product_type','brand','newId'));
    }

    public function create(ProductRequest $request){
        $prod = Product::create(array(
            'productId' => $request->input('productId'),
            'productBrand' => trim($request->input('productBrand')),
            'productName' => trim($request->input('productName')),
            'productTypeId' => $request->input('productType'),
            'productDesc' => trim($request->input('productDesc')),
            'productIsActive' => 1
            ));
        $prod->save();
        \Session::flash('flash_message','Product successfully added.');
        return redirect('maintenance/product');
    }

    public function update(Request $request){
        $checkProd = Product::all();
        $isAdded = false;
        foreach ($checkProd as $prod) {
            if(!strcasecmp($prod->productId, $request->input('editId')) == 0 &&
                strcasecmp($prod->productName, trim($request->input('editProdName'))) == 0 && 
                strcasecmp($prod->productBrand, trim($request->input('editProdBrand'))) == 0 &&
                strcasecmp($prod->productTypeId, $request->input('editProdType')) == 0){
                $isAdded = true;
            } 
        }
        if(!$isAdded){
            $prod = Product::find($request->input('editId'));
            $prod->productBrand = trim($request->input('editProdBrand'));
            $prod->productName = trim($request->input('editProdName'));
            $prod->productDesc = trim($request->input('editProdDesc'));
            $prod->productTypeId = trim($request->input('editProdType'));
            $prod->save();
            \Session::flash('flash_message','Product successfully updated.');
        }
        else{
            \Session::flash('error_message','Product already exists. Update failed.');
        }
        return redirect('maintenance/product');
    }

    public function destroy(Request $request){
        $prod = Product::find($request->input('delProdId'));
        $prod->productIsActive = 0;
        $prod->save();
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
