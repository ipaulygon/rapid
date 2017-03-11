<?php

namespace App\Http\Controllers;
use App\Product;
use App\ProductType;
use App\ProductVariance;
use App\Variance;
use App\Brand;
use App\Supplier;
use App\OrderSupplyHeader;
use App\OrderSupplyDetail;
use App\DeliveryHeader;
use App\DeliveryDetail;
use App\DeliveryOrder;
use PDF;

use Illuminate\Http\Request;

class ReceiveDeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $delivery = DeliveryHeader::with('supplier')->where('deliveryIsActive','=',1)->get();
    	return view('Transaction.receive-delivery',compact('delivery'));
    }

    public function createForm(){
        $delivery_max = \DB::table('delivery_header')->count('deliveryHId');
        $delivery_max = $delivery_max + 1;
        $newId = 'DELI'.str_pad($delivery_max, 6, '0', STR_PAD_LEFT); 
    	$products = ProductVariance::with('product.types')->with('product.brand')->with('variance.unit')->where('pvIsActive','=',1)->get();
    	$supplier = Supplier::where('supplierIsActive','=',1)->get();
        $orders = OrderSupplyHeader::where('purchaseHIsActive','=',1)->get();
    	return view('Transaction.receive-delivery-form',compact('newId','supplier','products','orders'));
    }

    public function create(){
        echo "hello";
    }
}
