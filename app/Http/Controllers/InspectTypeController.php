<?php

namespace App\Http\Controllers;
use App\Http\Requests\InspectTypeRequest;
use App\InspectType;

use Illuminate\Http\Request;

class InspectTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $itype_max = \DB::table('inspect_type')->count('inspectTypeId');
        $itype_max = $itype_max + 1;
        $newIdType = 'INSTYP'.str_pad($itype_max, 3, '0', STR_PAD_LEFT); 
    	$inspect_type = InspectType::get();
    	return view('Maintenance.Service.inspection_type',compact('inspect_type','newIdType'));
    }

    public function create(InspectTypeRequest $request){
        $type = InspectType::create(array(
            'inspectTypeId' => $request->input('inspectTypeId'),
            'inspectTypeName' => trim($request->input('inspectTypeName')),
            'inspectTypeDesc' => trim($request->input('inspectTypeDesc')),
            'inspectTypeIsActive' => 1
            ));
        $type->save();
        \Session::flash('flash_message','Inspection Type successfully added.');
        return redirect('maintenance/inspect-type');
    }

    public function update(Request $request){
        $checkInspectType = InspectType::all();
        $isAdded = false;
        foreach ($checkInspectType as $inspectType) {
            if(!strcasecmp($inspectType->inspectTypeId, $request->input('editInspectTypeId')) == 0 
                && strcasecmp($inspectType->inspectTypeName, trim($request->input('editInspectTypeName'))) == 0){
                $isAdded = true;
            }
        }
        if(!$isAdded){
            $inspectType = InspectType::find($request->input('editInspectTypeId'));
            $inspectType->inspectTypeName = trim($request->input('editInspectTypeName'));
            $inspectType->inspectTypeDesc = trim($request->input('editInspectTypeDesc'));
            $inspectType->save();
            \Session::flash('flash_message','Inspection Type successfully updated.');
        }else{
            \Session::flash('error_message','Inspection Type already exists. Update failed.');
        }
        return redirect('maintenance/inspect-type');
    }

    public function destroy(Request $request){
        $id = $request->input('delInspectTypeId');
        $inspectType = InspectType::find($request->input('delInspectTypeId'));
        $inspectType->inspectTypeIsActive = 0;
        $inspectType->save();
        \Session::flash('flash_message','Inspection Type successfully deactivated.');
        return redirect('maintenance/inspect-type');
    }
}
