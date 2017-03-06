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
use App\Http\Requests\OrderSupplyRequest;
use PDF;

use Illuminate\Http\Request;

class OrderSupplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $orders = OrderSupplyHeader::where('purchaseHIsActive','=',1)->get();
    	return view('Transaction.order-supply',compact('orders'));
    }

    public function createForm(){
        $order_max = \DB::table('purchase_header')->count('purchaseHId');
        $order_max = $order_max + 1;
        $newId = 'PO'.str_pad($order_max, 6, '0', STR_PAD_LEFT); 
    	$products = ProductVariance::with('product.types')->with('product.brand')->with('variance.unit')->where('pvIsActive','=',1)->get();
    	$supplier = Supplier::where('supplierIsActive','=',1)->get();
    	return view('Transaction.order-supply-form',compact('newId','supplier','products'));
    }

    public function create(Request $request){
    	$order = OrderSupplyHeader::create(array(
            'purchaseHId' => $request->input('orderId'),
            'purchaseHSupplierId' => trim($request->input('orderSupplierId')),
            'purchaseHDesc' => trim($request->input('orderDesc')),
            'purchaseHIsActive' => 1
            ));
        $order->save();
        $product = trim($request->input('orderProductId'));
        $products = explode(',',$product);
        $qty = $request->input('qty');
        $desc = $request->input('desc');
        $x = 0;
        foreach ($products as $prod) {
            $order_detail = OrderSupplyDetail::create(array(
                'purchaseHDId' => $request->input('orderId'),
                'purchaseDVarianceId' => $prod,
                'purchaseDQty' => $qty[$x],
                'purchaseDRemarks' => $desc[$x]
            ));
            $order_detail->save();
            $x++;
        }
        \Session::flash('flash_message','Purchase order successfully added.');
        return redirect('transaction/order-supply');
    }

    public function updateForm($id){
        $order = OrderSupplyHeader::with('supplier')->with('detail.variance.product.types')->with('detail.variance.product.brand')->with('detail.variance.variance.unit')->where('purchaseHId','=',$id)->get();
        $products = ProductVariance::with('product.types')->with('product.brand')->with('variance.unit')->where('pvIsActive','=',1)->get();
        $supplier = Supplier::where('supplierIsActive','=',1)->get();
        return view('Transaction.order-supply-form-update',compact('order','products','supplier'));
    }

    public function update(Request $request){
        $this->validate($request, [
            'editOrderSupplierId' => 'required',
            'editOrderProductId' => 'required',
        ]);
        $id = $request->input('editOrderId');
        $order = OrderSupplyHeader::find($id);
        $order->purchaseHSupplierId = trim($request->input('editOrderSupplierId'));
        $order->purchaseHDesc = trim($request->input('editOrderDesc'));
        $order->save();
        $deletedRows = OrderSupplyDetail::where('purchaseHDId','=',$id)->delete();
        $product = trim($request->input('editOrderProductId'));
        $products = explode(',',$product);
        $qty = $request->input('qty');
        $desc = $request->input('desc');
        $x = 0;
        foreach ($products as $prod) {
            $order_detail = OrderSupplyDetail::create(array(
                'purchaseHDId' => $id,
                'purchaseDVarianceId' => $prod,
                'purchaseDQty' => $qty[$x],
                'purchaseDRemarks' => $desc[$x]
            ));
            $order_detail->save();
            $x++;
        }
        \Session::flash('flash_message','Purchase order successfully updated.');
        return redirect('transaction/order-supply');
    }

    public function view($id){
        $pdf = PDF::loadView('pdf.order-supply-pdf')
        ->setPaper('Letter');
        return $pdf->stream();
    }
}
