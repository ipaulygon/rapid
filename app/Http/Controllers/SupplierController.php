<?php

namespace App\Http\Controllers;
use App\Http\Requests\SupplierRequest;
use App\Supplier;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $title = "Maintenance - Supplier";
    	$supp_max = \DB::table('supplier')->count('supplierId');
        $supp_max = $supp_max + 1;
        $newId = 'SUPP'.str_pad($supp_max, 4, '0', STR_PAD_LEFT); 
    	$supplier = Supplier::get();
    	return view('Maintenance.Inventory.supplier',compact('title','supplier','newId'));
    }

    public function create(SupplierRequest $request){
        $supplier = Supplier::create(array(
            'supplierId' => $request->input('supplierId'),
            'supplierName' => trim($request->input('supplierName')),
            'supplierPerson' => trim($request->input('supplierPerson')),
            'supplierContact' => trim($request->input('supplierContact')),
            'supplierAddress' => trim($request->input('supplierAddress')),
            'supplierIsActive' => 1
            ));
        $supplier->save();
        \Session::flash('flash_message','Supplier successfully added.');
        return redirect('maintenance/supplier');
    }

    public function update(Request $request){
        $this->validate($request, [
            'editSupplierName' => 'required',
            'editSupplierPerson' => 'required',
            'editSupplierContact' => 'required|numeric|regex:/^\d{11}$/',
        ]);
    	$checksuppliers = Supplier::all();
        $isAdded = false;
        foreach ($checksuppliers as $supplier) {
        	if(!strcasecmp($supplier->supplierId, $request->input('editSupplierId')) == 0 
        		&& strcasecmp($supplier->supplierName, trim($request->input('editSupplierName'))) == 0){
        		$isAdded = true;
        	}
        }
        if(!$isAdded){
            $supplier = Supplier::find($request->input('editSupplierId'));
            $supplier->supplierName = trim($request->input('editSupplierName'));
            $supplier->supplierPerson = trim($request->input('editSupplierPerson'));
            $supplier->supplierContact = trim($request->input('editSupplierContact'));
            $supplier->supplierAddress = trim($request->input('editSupplierAddress'));
            $supplier->save();
            \Session::flash('flash_message','Supplier successfully updated.');
        }else{
            \Session::flash('error_message','Supplier already exists. Update failed.');
        }
        return redirect('maintenance/supplier');
    }

    public function destroy(Request $request){
        $id = $request->input('delSupplierId');
        $supplier = Supplier::find($request->input('delSupplierId'));
        $supplier->supplierIsActive = 0;
        $supplier->save();
        \Session::flash('flash_message','Supplier successfully deactivated.');
        return redirect('maintenance/supplier');
    }
}
