<?php

namespace App\Http\Controllers;
use App\Http\Requests\VarianceRequest;
use App\Variance;
use App\Unit;
use App\ProductType;
use App\TypeVariance;

use Illuminate\Http\Request;

class VarianceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$var_max = \DB::table('variance')->count('varianceId');
        $var_max = $var_max + 1;
        $newId = 'VAR'.str_pad($var_max, 4, '0', STR_PAD_LEFT); 
    	$variance = Variance::with('unit')->with('type.type')->get();
    	$unit = Unit::get();
        $types = ProductType::get();
    	return view('Maintenance.Inventory.product_variance',compact('variance','unit','types','newId'));
    }

    public function create(VarianceRequest $request){
        $variance = Variance::create(array(
            'varianceId' => $request->input('varianceId'),
            'varianceSize' => trim($request->input('varianceSize')),
            'varianceUnitId' => trim($request->input('varianceUnitId')),
            'varianceDesc' => trim($request->input('varianceDesc')),
            'varianceIsActive' => 1
            ));
        $variance->save();
        $type = $request->input('types');
        $types = explode(',', $type);
        if($type!=null || $type!=''){
            foreach($types as $typ) {
                $tv = TypeVariance::create(array(
                    'tvTypeId' => $typ,
                    'tvVarianceId' => $request->input('varianceId'),
                    'tvIsActive' => 1
                    ));
                $tv->save();
            }
        }
        \Session::flash('flash_message','Variance successfully added.');
        return redirect('maintenance/product-variance');
    }

    public function update(Request $request){
        $this->validate($request, [
            'editVarianceSize' => 'required',
            'editVarianceUnitId' => 'required',
        ]);
    	$checkvariances = Variance::all();
        $isAdded = false;
        foreach ($checkvariances as $variance) {
        	if(!strcasecmp($variance->varianceId, $request->input('editVarianceId')) == 0 
        		&& strcasecmp($variance->varianceSize, trim($request->input('editVarianceSize'))) == 0
        		&& strcasecmp($variance->varianceUnitId, trim($request->input('editVarianceUnitId'))) == 0){
        		$isAdded = true;
        	}
        }
        if(!$isAdded){
            $variance = Variance::find($request->input('editVarianceId'));
            $variance->varianceSize = trim($request->input('editVarianceSize'));
            $variance->varianceUnitId = trim($request->input('editVarianceUnitId'));
            $variance->varianceDesc = trim($request->input('editVarianceDesc'));
            $variance->save();
            $affectedRows = TypeVariance::where('tvVarianceId', '=', $request->input('editVarianceId'))->update(['tvIsActive' => 0]);
            $type = $request->input('editTypes');
            $types = explode(',', $type);
            if($type!=null || $type!=''){
                foreach($types as $typ) {
                    $tv = TypeVariance::create(array(
                        'tvTypeId' => $typ,
                        'tvVarianceId' => $request->input('editVarianceId'),
                        'tvIsActive' => 1
                        ));
                    $tv->save();
                }
            }
            \Session::flash('flash_message','Variance successfully updated.');
        }else{
            \Session::flash('error_message','Variance already exists. Update failed.');
        }
        return redirect('maintenance/product-variance');
    }

    public function destroy(Request $request){
        $id = $request->input('delVarianceId');
        $variance = Variance::find($request->input('delVarianceId'));
        $variance->varianceIsActive = 0;
        $variance->save();
        \Session::flash('flash_message','Variance successfully deactivated.');
        return redirect('maintenance/product-variance');
    }
}
