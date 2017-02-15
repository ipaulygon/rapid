<?php

namespace App\Http\Controllers;
use App\Http\Requests\UnitRequest;
use App\Unit;

use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$unit_max = \DB::table('unit')->count('unitId');
        $unit_max = $unit_max + 1;
        $newId = 'UNIT'.str_pad($unit_max, 3, '0', STR_PAD_LEFT); 
    	$unit = Unit::get();
    	return view('Maintenance.Inventory.product_unit',compact('unit','newId'));
    }

    public function create(UnitRequest $request){
        $unit = Unit::create(array(
            'unitId' => $request->input('unitId'),
            'unitName' => trim($request->input('unitName')),
            'unitDesc' => trim($request->input('unitDesc')),
            'unitIsActive' => 1
            ));
        $unit->save();
        \Session::flash('flash_message','Unit successfully added.');
        return redirect('maintenance/product-unit');
    }

    public function update(Request $request){
    	$checkunits = Unit::all();
        $isAdded = false;
        foreach ($checkunits as $unit) {
        	if(!strcasecmp($unit->unitId, $request->input('editUnitId')) == 0 
        		&& strcasecmp($unit->unitName, trim($request->input('editUnitName'))) == 0){
        		$isAdded = true;
        	}
        }
        if(!$isAdded){
            $unit = Unit::find($request->input('editUnitId'));
            $unit->unitName = trim($request->input('editUnitName'));
            $unit->unitDesc = trim($request->input('editUnitDesc'));
            $unit->save();
            \Session::flash('flash_message','Unit successfully updated.');
        }else{
            \Session::flash('error_message','Unit already exists. Update failed.');
        }
        return redirect('maintenance/product-unit');
    }

    public function destroy(Request $request){
        $id = $request->input('delUnitId');
        $unit = Unit::find($request->input('delUnitId'));
        $unit->unitIsActive = 0;
        $unit->save();
        \Session::flash('flash_message','Unit successfully deactivated.');
        return redirect('maintenance/product-unit');
    }
}
