<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Package;
use App\Product;
use App\ProductType;
use App\Brand;
use App\Variance;
use App\Unit;
use App\ProductVariance;
use App\TypeVariance;
use App\Service;
use App\ServiceCategory;
use App\PackageProduct;
use App\PackageService;
use Validator;
use Redirect;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$package = Package::with('product.product.product.types')->with('product.product.product.brand')->with('product.product.variance.unit')->with('service.service.categories')->get();
        $product = ProductVariance::with('product.types')->with('product.brand')->with('variance.unit')->get();
    	$service = Service::with('categories')->get();
        //$pp = PackageProduct::with('product.product.brand')->with('product.product.types')->with('product.variance.unit')->get();
        return view('Maintenance.Sales.package',compact('package','product','service','dateNow','newId'));
    }

    public function createForm(){
        $package_max = \DB::table('package')->count('packageId');
        $package_max = $package_max + 1;
        $newId = 'PACKAGE'.str_pad($package_max, 4, '0', STR_PAD_LEFT); 
        $dateNow = date("Y-m-d");
        $package = Package::with('product.product.product.types')->with('product.product.product.brand')->with('product.product.variance.unit')->with('service.service.categories')->get();
        $product = ProductVariance::with('product.types')->with('product.brand')->with('variance.unit')->get();
        $service = Service::with('categories')->get();
        //$pp = PackageProduct::with('product.product.brand')->with('product.product.types')->with('product.variance.unit')->get();
        return view('Maintenance.Sales.package_form',compact('package','product','service','dateNow','newId'));
    }

    public function create(Request $request){
        $rules = array(
            'packageName' => 'required|unique:package',
            'packageCost' => 'required|numeric|between:0,99999999.99',
            'qty.*' => 'required|numeric|between:0,999'
        );
        $messages = [
            'unique' => ':attribute already exists.',
            'required' => 'The :attribute field is required.',
            'numeric' => ':attribute must be numeric.'
        ];
        $niceNames = array(
            'packageName' => 'Package',
            'packageCost' => 'Price',
            'qty.*' => 'Quantity'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            \Session::flash('new_error','Error');
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $package = Package::create(array(
                'packageId' => $request->input('packageId'),
                'packageName' => trim($request->input('packageName')),
                'packageDesc' => trim($request->input('packageDesc')),
                'packageCost' => trim($request->input('packageCost')),
                'packageIsActive' => 1
            ));
        $package->save();
        $prod = $request->input('packageProductId');
        $prods = explode(",", $prod);
        $serv = $request->input('packageServiceId');
        $servs = explode(",", $serv);
        $qty = $request->input('qty');
        if($prod!=null || $prod!=''){
            $x = 0;
            foreach ($prods as $prods) {
                $pp = PackageProduct::create(array(
                    'packagePId' => $request->input('packageId'),
                    'packageProductId' => $prods,
                    'packagePQty' => $qty[$x],
                    'packagePIsActive' => 1
                    ));
                $pp->save();
                $x++;
            }
        }
        if($serv!=null || $serv!=''){
            $x = 0;
            foreach ($servs as $servs) {
                $ps = PackageService::create(array(
                    'packageSId' => $request->input('packageId'),
                    'packageServiceId' => $servs,
                    'packageSIsActive' => 1
                    ));
                $ps->save();
                $x++;
            }
        }
        \Session::flash('flash_message','Package successfully added.');
        return redirect('maintenance/package');
    }

    public function update(Request $request){
        $eid = $request->input('editPackageId');
        $rules = array(
            'editPackageName' => 'required',
            'editPackageCost' => 'required|numeric|between:0,99999999.99',
            'qtys.*' => 'required|numeric|between:0,999'
        );
        $messages = [
            'required' => 'The :attribute field is required.',
            'numeric' => ':attribute must be numeric.'
        ];
        $niceNames = array(
            'editPackageName' => 'Package',
            'editPackageCost' => 'Cost',
            'qtys.*' => 'Quantity'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            \Session::flash('update_error',$eid);
            return Redirect::back()->withErrors($validator);
        }
        $checkPackage = Package::all();
        $isAdded = false;
        foreach ($checkPackage as $package) {
            if(!strcasecmp($package->packageId, $request->input('editPackageId')) == 0 
                && strcasecmp($package->packageName, trim($request->input('editPackageName'))) == 0){
                $isAdded = true;
            }
        }
        if(!$isAdded){
            $package = Package::find($request->input('editPackageId'));
            $package->packageName = trim($request->input('editPackageName'));
            $package->packageCost = trim($request->input('editPackageCost'));
            $package->packageDesc = trim($request->input('editPackageDesc'));
            $package->save();
            $prod = $request->input('editPackageProductId');
            $prods = explode(",", $prod);
            $serv = $request->input('editPackageServiceId');
            $servs = explode(",", $serv);
            $qty = $request->input('qtys');
            $affectedRows = PackageProduct::where('packagePId', '=', $request->input('editPackageId'))->update(['packagePIsActive' => 0]);
            if($prod!=null || $prod!=''){
                $x = 0;
                foreach ($prods as $prods) {
                    $pp = PackageProduct::create(array(
                        'packagePId' => $request->input('editPackageId'),
                        'packageProductId' => $prods,
                        'packagePQty' => $qty[$x],
                        'packagePIsActive' => 1
                        ));
                    $pp->save();
                    $x++;
                }
            }
            $affectedRows = PackageService::where('packageSId', '=', $request->input('editPackageId'))->update(['packageSIsActive' => 0]);
            if($serv!=null || $serv!=''){
                $x = 0;
                foreach ($servs as $servs) {
                    $ps = PackageService::create(array(
                        'packageSId' => $request->input('editPackageId'),
                        'packageServiceId' => $servs,
                        'packageSIsActive' => 1
                        ));
                    $ps->save();
                    $x++;
                }
            }
            \Session::flash('flash_message','Package successfully updated.');
        }else{
            \Session::flash('update_error',$eid);
            \Session::flash('update_unique','Error');
            return Redirect::back()->withErrors($validator)->withInput();
        }
        return redirect('maintenance/package');
    }

    public function destroy(Request $request){
        $id = $request->input('delPackageId');
        $package = Package::find($request->input('delPackageId'));
        $package->packageIsActive = 0;
        $package->save();
        \Session::flash('flash_message','Package successfully deleted.');
        return redirect('maintenance/package');
    }

    public function view($id){
        $package = Package::with('product.product.product.types')->with('product.product.product.brand')->with('product.product.variance.unit')->with('service.service.categories')->where('packageId','=',$id)->get();
        $product = ProductVariance::with('product.types')->with('product.brand')->with('variance.unit')->get();
        $service = Service::with('categories')->get();
        $pp = PackageProduct::with('product.product.brand')->with('product.product.types')->with('product.variance.unit')->where('packagePId','=',$id)->get();
        $pd = PackageProduct::with('product.product.brand')->with('product.product.types')->with('product.variance.unit')->where('packagePId','=',$id)->get();
        $ps = PackageService::with('service.categories')->where('packageSId','=',$id)->get();
        return view('Maintenance.Sales.package_update',compact('package','product','service','pp','ps','pd'));
        //return \Response::json(array('$package'=>$package));
    }
}
