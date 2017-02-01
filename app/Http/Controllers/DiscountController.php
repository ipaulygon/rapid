<?php

namespace App\Http\Controllers;
use App\Http\Requests\DiscountRequest;
use App\Discount;

use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	//smartCounter
    	$ids = \DB::table('discount')
        	->select('discountId')
            ->orderBy('created_at', 'desc')
            ->orderBy('discountId', 'desc')
            ->take(1)
            ->get();
        $id = $ids["0"]->discountId;
        $newId = $this->smartCounter($id);
    	$discount = Discount::get();
    	return view('Maintenance.Sales.discount',compact('discount','newId'));
    }

    public function create(DiscountRequest $request){
        $discount = Discount::create(array(
            'discountId' => $request->input('discountId'),
            'discountName' => trim($request->input('discountName')),
            'discountRate' => trim($request->input('discountRate')),
            'discountIsActive' => 1
            ));
        $discount->save();
        \Session::flash('flash_message','Discount successfully added.');
        return redirect('maintenance/discount');
    }

    public function update(Request $request){
    	$checkDis = Discount::all();
        $isAdded = false;
        foreach ($checkDis as $discount) {
        	if(!strcasecmp($discount->discountId, $request->input('editDiscountId')) == 0 
        		&& strcasecmp($discount->discountName, trim($request->input('editDiscountName'))) == 0){
        		$isAdded = true;
        	}
        }
        if(!$isAdded){
            $discount = Discount::find($request->input('editDiscountId'));
            $discount->discountName = trim($request->input('editDiscountName'));
            $discount->discountRate = trim($request->input('editDiscountRate'));
            $discount->save();
            \Session::flash('flash_message','Discount successfully updated.');
        }else{
            \Session::flash('error_message','Discount already exists. Update failed.');
        }
        return redirect('maintenance/discount');
    }

    public function destroy(Request $request){
        $id = $request->input('delDiscountId');
        $discount = Discount::find($request->input('delDiscountId'));
        $discount->discountIsActive = 0;
        $discount->save();
        \Session::flash('flash_message','Discount successfully deleted.');
        return redirect('maintenance/discount');
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
