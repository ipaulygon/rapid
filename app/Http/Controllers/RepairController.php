<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $delivery = DeliveryHeader::with('supplier')->where('deliveryIsActive','=',1)->get();
    	return view('Transaction.receive-delivery',compact('delivery'));
    }
}
