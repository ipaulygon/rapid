<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductTypeRequest;
use App\ProductType;

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

    public function create(ProductTypeRequest $request){
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
        $this->validate($request, [
            'editTypeName' => 'required',
        ]);
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
            \Session::flash('error_message','Product type already exists. Update failed.');
        }
        return redirect('maintenance/product-type');
    }

    public function destroy(Request $request){
        $id = $request->input('delTypeId');
        $type = ProductType::find($request->input('delTypeId'));
        $type->typeIsActive = 0;
        $type->save();
        \Session::flash('flash_message','Product type successfully deactivated.');
        return redirect('maintenance/product-type');
    }
}
