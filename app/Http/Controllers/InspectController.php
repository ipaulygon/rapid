<?php

namespace App\Http\Controllers;
use App\InspectItem;
use App\InspectType;
use App\InspectHeader;
use App\InspectDetail;
use App\Vehicle;
use App\VehicleMake;
use App\VehicleModel;
use App\Customer;

use Illuminate\Http\Request;

class InspectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $inspect_max = \DB::table('inspect_header')->count('inspectHId');
        $inspect_max = $inspect_max + 1;
        $newId = 'INSPECT'.str_pad($inspect_max, 6, '0', STR_PAD_LEFT); 
    	$inspect = InspectHeader::with('details')->get();
        $vehicle = Vehicle::where('vehicleIsActive','=',1)->get();
        $make = VehicleMake::get();
        $model = VehicleModel::get();
        $inspectType = InspectType::where('inspectTypeIsActive','=',1)->with('item')->get();
    	return view('Transaction.inspect',compact('inspect','newId','vehicle','make','model','inspectType'));
    }
}
