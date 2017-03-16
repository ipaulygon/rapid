<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Variance;
use App\Unit;
use App\ProductType;
use App\TypeVariance;
use App\ProductVariance;
use App\Product;
use Validator;
use Redirect;

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

    public function create(Request $request){
        $rules = array(
            'varianceSize' => 'required|unique:variance',
            'varianceUnitId' => 'required|unique_with:variance,varianceSize',
        );
        $messages = [
            'unique' => ':attribute already exists.',
            'required' => 'The :attribute field is required.',
        ];
        $niceNames = array(
            'varianceSize' => 'Size',
            'varianceUnitId' => 'Unit Id',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            \Session::flash('new_error','Error');
            return Redirect::back()->withErrors($validator)->withInput();
        }
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
        $eid = $request->input('editVarianceId');
        $rules = array(
            'editVarianceSize' => 'required',
            'editVarianceUnitId' => 'required',
        );
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $niceNames = array(
            'editVarianceSize' => 'Size',
            'editVarianceUnitId' => 'Unit Id',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            \Session::flash('update_error',$eid);
            return Redirect::back()->withErrors($validator);
        }
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
            $id = $request->input('editVarianceId');
            $variance = Variance::find($id);
            $variance->varianceSize = trim($request->input('editVarianceSize'));
            $variance->varianceUnitId = trim($request->input('editVarianceUnitId'));
            $variance->varianceDesc = trim($request->input('editVarianceDesc'));
            $variance->save();
            //$affectedRows = TypeVariance::where('tvVarianceId', '=', $request->input('editVarianceId'))->update(['tvIsActive' => 0]);
            $type = $request->input('editTypes');
            $types = explode(',', $type);
            $type_variance = TypeVariance::where('tvVarianceId','=',$id)->where('tvIsActive','=',1)->count();
            if($type_variance==0){
                if($type!=null || $type!=''){
                    foreach($types as $typ) {
                        $tv = TypeVariance::create(array(
                            'tvTypeId' => $typ,
                            'tvVarianceId' => $id,
                            'tvIsActive' => 1
                            ));
                        $tv->save();
                    }
                }
            }
            else{
                $isUsed = false;
                $type_variance = TypeVariance::where('tvVarianceId','=',$id)->where('tvIsActive','=',1)->get();
                if($type!=null || $type!=''){
                    foreach($type_variance as $tv){
                        if(!in_array($tv->tvTypeId, $types)){
                            $product = Product::where('productIsActive','=',1)->where('productTypeId','=',$tv->tvTypeId)->count();
                            if($product>0){
                                $isUsed = true;
                            }
                            else{
                                $tvd = TypeVariance::where('tvVarianceId','=',$id)->where('tvTypeId','=',$tv->tvTypeId)->where('tvIsActive','=',1)->update(['tvIsActive' => 0]);
                            }
                        }
                        $types = array_diff($types,array($tv->tvTypeId));
                    }
                    foreach($types as $typ){
                        $tv = TypeVariance::create(array(
                            'tvTypeId' => $typ,
                            'tvVarianceId' => $id,
                            'tvIsActive' => 1
                            ));
                        $tv->save();
                    }
                }
                else{
                    $type_variance = TypeVariance::where('tvVarianceId','=',$id)->where('tvIsActive','=',1)->get();
                    foreach($type_variance as $tv){
                        $product = Product::where('productIsActive','=',1)->where('productTypeId','=',$tv->tvTypeId)->count();
                        if($product>0){
                            $isUsed = true;
                        }
                        else{
                            $tvd = TypeVariance::where('tvVarianceId','=',$id)->where('tvTypeId','=',$tv->tvTypeId)->where('tvIsActive','=',1)->update(['tvIsActive' => 0]);
                        }
                    }
                }
                if($isUsed){
                    \Session::flash('warning_message','Some of the types were not updated/deactivated because it is used by products. Variance updated');
                    return redirect('maintenance/product-variance');
                }
                else{
                    \Session::flash('warning_message','Some of the types were not updated/deactivated because it is used by products. Variance updated');
                    return redirect('maintenance/product-variance');
                }
            }
            \Session::flash('flash_message','Variance successfully updated.');
        }else{
            \Session::flash('update_error',$eid);
            \Session::flash('update_unique','Error');
            return Redirect::back()->withErrors($validator)->withInput();
        }
        return redirect('maintenance/product-variance');
    }

    public function destroy(Request $request){
        $id = $request->input('delVarianceId');
        $product_variance = ProductVariance::with('variance')->where('pvVarianceId','=',$id)->where('pvIsActive','=',1)->count();
        if($product_variance>0){
            \Session::flash('error_message','Variance is still being used in products. Deactivation failed');
            return redirect('maintenance/product-variance');
        }
        else{
            $variance = Variance::find($request->input('delVarianceId'));
            $variance->varianceIsActive = 0;
            $variance->save();
            $affectedRows = TypeVariance::where('tvVarianceId', '=', $id)->update(['tvIsActive' => 0]);
            \Session::flash('flash_message','Variance successfully deactivated.');
            return redirect('maintenance/product-variance');
        }
        
    }
}
