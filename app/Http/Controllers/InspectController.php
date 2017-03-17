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
use App\Technician;

use Illuminate\Http\Request;

class InspectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$inspect = InspectHeader::with('details')->get();
        $vehicle = Vehicle::where('vehicleIsActive','=',1)->get();
        $make = VehicleMake::get();
        $model = VehicleModel::get();
        $tech = Technician::where('techIsActive','=',1)->get();
        $inspectType = InspectType::where('inspectTypeIsActive','=',1)->with('item')->get();
    	return view('Transaction.inspect',compact('inspect','vehicle','make','model','inspectType','tech'));
    }

    public function createForm(){
        $inspect_max = \DB::table('inspect_header')->count('inspectHId');
        $inspect_max = $inspect_max + 1;
        $newId = 'INSPECT'.str_pad($inspect_max, 6, '0', STR_PAD_LEFT);
        $inspect = InspectHeader::with('details')->get();
        $vehicle = Vehicle::where('vehicleIsActive','=',1)->get();
        $make = VehicleMake::get();
        $model = VehicleModel::get();
        $tech = Technician::where('techIsActive','=',1)->get();
        $inspectType = InspectType::where('inspectTypeIsActive','=',1)->with('item')->get();
        return view('Transaction.inspect-form',compact('inspect','newId','vehicle','make','model','inspectType','tech'));
    }

    public function create(Request $request){
        \Session::flash('flash_message','Inspection successfully added.');
        return redirect('transaction/inspect');
        $vehiclePlateId = trim($request->input('vehiclePlateId'));
        if($vehiclePlateId=='' || $vehiclePlateId==null){
            $vehicleMakeId = trim($request->input('vehicleMakeId'));
            $vehicleMake = trim($request->input('vehicleMake'));
            if($vehicleMakeId=='' || $vehicleMakeId==null){
                $make_max = \DB::table('vehicle_make')->count('makeId');
                $make_max = $make_max + 1;
                $newId = 'MAKE'.str_pad($make_max, 4, '0', STR_PAD_LEFT); 
                $make = VehicleMake::create(array(
                    'makeId' => $newId,
                    'makeName' => $vehicleMake,
                ));
                $make->save();
                $vehicleMakeId = VehicleMake::where('makeName','=',$vehicleMake)->orderBy('modelId','desc')->first();
                $vehicleMakeId = $vehicleMakeId[0]->makeId;
            }
            $vehicleModelId = trim($request->input('vehicleModelId'));
            $vehicleModel = trim($request->input('vehicleModel'));
            if($$vehicleModelId=='' || $vehicleModelId==null){
                $model_max = \DB::table('vehicle_model')->count('modelId');
                $model_max = $model_max + 1;
                $newId = 'MODEL'.str_pad($model_max, 4, '0', STR_PAD_LEFT); 
                $model = VehicleModel::create(array(
                    'modelId' => $newId,
                    'modelName' => $vehicleModel,
                ));
                $model->save();
                $vehicleModelId = VehicleModel::where('modelName','=',$vehicleModel)->orderBy('modelId','desc')->first();
                $vehicleModelId = $vehicleModelId[0]->modelId;
            }
        }else{
                        
        }
        
        $inspect = InspectHeader::create(array(
            ''
        ));
    }
}
