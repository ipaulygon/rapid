<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\ProductType;
use App\Brand;
use App\Variance;

use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	/*$ids = \DB::table('product')
            ->select('productId')
            ->orderBy('created_at', 'desc')
            ->orderBy('productId', 'desc')
            ->take(1)
            ->get();
        $id = $ids["0"]->productId;
        $newId = $this->smartCounter($id);*/
        $newId = "PROD0001";
    	$type = ProductType::get();
        $brand = Brand::get();
        $variance = Variance::with('unit')->get();
        $product = Product::with('types')->with('brand')->get();
        return view('Maintenance.Inventory.product',compact('product','type','brand','variance','newId'));
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
