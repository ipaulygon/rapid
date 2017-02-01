<?php

namespace App\Http\Controllers;
use App\Http\Requests\BrandRequest;
use App\Brand;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	//smartCounter
    	$ids = \DB::table('brand')
        	->select('brandId')
            ->orderBy('created_at', 'desc')
            ->orderBy('brandId', 'desc')
            ->take(1)
            ->get();
        $id = $ids["0"]->brandId;
        $newId = $this->smartCounter($id);
    	$brand = Brand::get();
    	return view('Maintenance.Inventory.product_brand',compact('brand','newId'));
    }

    public function create(BrandRequest $request){
        $brand = Brand::create(array(
            'brandId' => $request->input('brandId'),
            'brandName' => trim($request->input('brandName')),
            'brandDesc' => trim($request->input('brandDesc')),
            'brandIsActive' => 1
            ));
        $brand->save();
        \Session::flash('flash_message','Brand successfully added.');
        return redirect('maintenance/product-brand');
    }

    public function update(Request $request){
    	$checkbrands = Brand::all();
        $isAdded = false;
        foreach ($checkbrands as $brand) {
        	if(!strcasecmp($brand->brandId, $request->input('editBrandId')) == 0 
        		&& strcasecmp($brand->brandName, trim($request->input('editBrandName'))) == 0){
        		$isAdded = true;
        	}
        }
        if(!$isAdded){
            $brand = Brand::find($request->input('editBrandId'));
            $brand->brandName = trim($request->input('editBrandName'));
            $brand->brandDesc = trim($request->input('editBrandDesc'));
            $brand->save();
            \Session::flash('flash_message','Brand successfully updated.');
        }else{
            \Session::flash('error_message','Brand already exists. Update failed.');
        }
        return redirect('maintenance/product-brand');
    }

    public function destroy(Request $request){
        $id = $request->input('delBrandId');
        $brand = Brand::find($request->input('delBrandId'));
        $brand->brandIsActive = 0;
        $brand->save();
        \Session::flash('flash_message','Brand successfully deleted.');
        return redirect('maintenance/product-brand');
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
