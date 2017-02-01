<?php

namespace App\Http\Controllers;
use App\Http\Requests\VarianceRequest;
use App\Variance;
use App\Unit;

use Illuminate\Http\Request;

class VarianceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	//smartCounter
    	$ids = \DB::table('variance')
        	->select('varianceId')
            ->orderBy('created_at', 'desc')
            ->orderBy('varianceId', 'desc')
            ->take(1)
            ->get();
        $id = $ids["0"]->varianceId;
        $newId = $this->smartCounter($id);
    	$variance = Variance::with('unit')->get();
    	$unit = Unit::get();
    	return view('Maintenance.Inventory.product_variance',compact('variance','unit','newId'));
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
        \Session::flash('flash_message','Variance successfully added.');
        return redirect('maintenance/product-variance');
    }

    public function update(Request $request){
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
        \Session::flash('flash_message','Variance successfully deleted.');
        return redirect('maintenance/product-variance');
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