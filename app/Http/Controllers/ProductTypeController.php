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
    	//smartCounter
    	$ids = \DB::table('product_type')
        	->select('typeId')
            ->orderBy('created_at', 'desc')
            ->orderBy('typeId', 'desc')
            ->take(1)
            ->get();
        $id = $ids["0"]->typeId;
        $newId = $this->smartCounter($id);
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
        \Session::flash('flash_message','Product type successfully deleted.');
        return redirect('maintenance/product-type');
    }

    public function smartCounter($id)
    {   
        $lastID = str_split($id);
        $ctr = 0;
        $tempID = "";
        $tempNew = [];
        $newID = "";
        $add = TRUE;
        for($ctr = count($lastID)-1; $ctr >= 0; $ctr--){
            $tempID = $lastID[$ctr];
            if($add){
                if(is_numeric($tempID) || $tempID == '0'){
                    if($tempID == '9'){
                        $tempID = '0';
                        $tempNew[$ctr] = $tempID;
                    }else{
                        $tempID = $tempID + 1;
                        $tempNew[$ctr] = $tempID;
                        $add = FALSE;
                    }
                }else{
                    $tempNew[$ctr] = $tempID;
                }           
            }
            $tempNew[$ctr] = $tempID;   
        }
        
        for($ctr = 0; $ctr < count($lastID); $ctr++){
            $newID = $newID . $tempNew[$ctr];
        }
        return $newID;
    }
}
