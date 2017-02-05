<?php

namespace App\Http\Controllers;
use App\InspectItem;
use App\InspectType;
use App\InspectHeader;
use App\InspectDetail;
use App\Vehicle;
use App\VehicleMake;
use App\VehicleModel;

use Illuminate\Http\Request;

class InspectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	//smartCounter
    	/*$ids = \DB::table('inspect_header')
        	->select('inspectHId')
            ->orderBy('created_at', 'desc')
            ->orderBy('inspectHId', 'desc')
            ->take(1)
            ->get();*/
       /* $id = $ids["0"]->brandId*/;
        $newId = "INSPECT00001";/*$this->smartCounter($id)*/
    	$inspect = InspectHeader::with('details')->get();
        $vehicle = Vehicle::get();
        $make = VehicleMake::get();
        $model = VehicleModel::get();
        $inspectType = InspectType::with('item')->get();
    	return view('Transaction.inspect',compact('inspect','newId','vehicle','make','model','inspectType'));
    }
}
