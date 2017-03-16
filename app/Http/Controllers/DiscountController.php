<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Discount;
use Validator;
use Redirect;

use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $discount_max = \DB::table('discount')->count('discountId');
        $discount_max = $discount_max + 1;
        $newId = 'DS'.str_pad($discount_max, 3, '0', STR_PAD_LEFT); 
    	$discount = Discount::get();
    	return view('Maintenance.Sales.discount',compact('discount','newId'));
    }

    public function create(Request $request){
        $rules = array(
            'discountName' => 'required|unique:discount',
            'discountRate' => 'numeric|required|between:0,99', 
        );
        $messages = [
            'unique' => ':attribute already exists.',
            'required' => 'The :attribute field is required.',
            'numeric' => ':attribute must be numeric'
        ];
        $niceNames = array(
            'discountName' => 'Discount',
            'discountRate' => 'Rate'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            \Session::flash('new_error','Error');
            return Redirect::back()->withErrors($validator)->withInput();
        }
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
        $eid = $request->input('editDiscountId');
        $rules = array(
            'editDiscountName' => 'required',
            'editDiscountRate' => 'numeric|required|between:0,99',
        );
        $messages = [
            'required' => 'The :attribute field is required.',
            'numeric' => ':attribute must be numeric'
        ];
        $niceNames = array(
            'editDiscountName' => 'Discount',
            'editDiscountRate' => 'Rate',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            \Session::flash('update_error',$eid);
            return Redirect::back()->withErrors($validator);
        }
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
            \Session::flash('update_error',$eid);
            \Session::flash('update_unique','Error');
            return Redirect::back()->withErrors($validator)->withInput();
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
}
