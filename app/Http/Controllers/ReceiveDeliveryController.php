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

    public function create(Request $request){
        $id = trim($request->input('deliveryId'));
        $supplier = trim($request->input('deliverySupplierId'));
        $deliveryHeader = DeliveryHeader::create(array(
            'deliveryHId' => $id,
            'deliveryHSupplierId' => $supplier,
            'deliveryIsActive' => 1
        ));
        $deliveryHeader->save();
        $order = trim($request->input('deliveryOrderId'));
        $orders = explode(',',$order);
        $var = $request->input('variances');
        $x = 0;
        foreach($orders as $orders){
            $deliveryOrder = DeliveryOrder::create(array(
                'deliveryOrderId' => $orders,
                'deliveryOHeaderId' => $id,
                'deliveryOIsActive' => 1
            ));
            $deliveryOrder->save();
            $qty = $request->input('qty'.$orders);
            foreach ($qty as $qty) {
                $deliveryDetail = DeliveryDetail::create(array(
                    'deliveryHDId' => $id,
                    'deliveryDVarianceId' => $var[$x],
                    'deliveryDQty' => $qty,
                    'deliveryDRemarks' => $id
                ));
                $deliveryDetail->save();
                $detail = OrderSupplyDetail::where('purchaseHDId','=',$orders)->where('purchaseDVarianceId','=',$var[$x])->first();
                $declaredQty = $detail->purchaseDeliveredQty+$qty;
                OrderSupplyDetail::where('purchaseHDId','=',$orders)->where('purchaseDVarianceId','=',$var[$x])->update(['purchaseDeliveredQty' => $declaredQty]);
                $x++;
            }
        }
        \Session::flash('flash_message','Delivery successfully added.');
        return redirect('transaction/receive-delivery');
    }

    public function supplier(Request $request){
        $suppId = $request->input('id');
        $data = OrderSupplyHeader::where('purchaseHSupplierId','=',$suppId)->where('purchaseHIsActive','=',1)->get();
        return \Response::json(array('data'=>$data));
    }

    public function order(Request $request){
        $poId = $request->input('id');
        $data = OrderSupplyDetail::with('variance.product.types')->with('variance.product.brand')->with('variance.variance.unit')->where('purchaseHDId','=',$poId)->get();
        return \Response::json(array('data'=>$data));
    }
}
