<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\ProductType;
use App\TypeVariance;
use App\Product;
use Validator;
use Redirect;

use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$type_max = \DB::table('product_type')->count('typeId');
        $type_max = $type_max + 1;
        $newId = 'TYPE'.str_pad($type_max, 3, '0', STR_PAD_LEFT); 
    	$product_type = ProductType::get();
    	return view('Maintenance.Inventory.product_type',compact('product_type','newId'));
    }

    public function create(Request $request){
        $rules = array(
            'typeName' => 'required|unique:product_type',
        );
        $messages = [
            'unique' => ':attribute already exists.',
            'required' => 'The :attribute field is required.',
        ];
        $niceNames = array(
            'typeName' => 'Type',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            \Session::flash('new_error','Error');
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $type = ProductType::create(array(
            'typeId' => $request->input('typeId'),
            'typeName' => trim($request->input('typeName')),
            'typeDesc' => trim($request->input('typeDesc')),
            'typeIsActive' => 1
            ));
        $type->save();
        \Session::flash('flash_message','Product type successfully added.');
        return redirect('maintenance/product-type');
    }

    public function update(Request $request){
        $eid = $request->input('editTypeId');
        $rules = array(
            'editTypeName' => 'required',
        );
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $niceNames = array(
            'editTypeName' => 'Type',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            \Session::flash('update_error',$eid);
            return Redirect::back()->withErrors($validator);
        }
    	$checkTypes = ProductType::all();
        $isAdded = false;
        foreach ($checkTypes as $type) {
        	if(!strcasecmp($type->typeId, $request->input('editTypeId')) == 0 
        		&& strcasecmp($type->typeName, trim($request->input('editTypeName'))) == 0){
        		$isAdded = true;
        	}
        }
        if(!$isAdded){
            $type = ProductType::find($request->input('editTypeId'));
            $type->typeName = trim($request->input('editTypeName'));
            $type->typeDesc = trim($request->input('editTypeDesc'));
            $type->save();
            \Session::flash('flash_message','Product type successfully updated.');
        }else{
            \Session::flash('update_error',$eid);
            \Session::flash('update_unique','Error');
            return Redirect::back()->withErrors($validator)->withInput();
        }
        return redirect('maintenance/product-type');
    }

    public function destroy(Request $request){
        $id = $request->input('delTypeId');
        $product_type = Product::with('types')->where('productTypeId','=',$id)->where('productIsActive','=',1)->count();
        if($product_type>0){
            \Session::flash('error_message','Product type is still being used in products. Deactivation failed');
            return redirect('maintenance/product-type');
        }
        else{
            $type = ProductType::find($request->input('delTypeId'));
            $type->typeIsActive = 0;
            $type->save();
            $affectedRows = TypeVariance::where('tvTypeId', '=', $id)->update(['tvIsActive' => 0]);
            \Session::flash('flash_message','Product type successfully deactivated.');
            return redirect('maintenance/product-type');
        }
    }
}
