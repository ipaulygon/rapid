<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PackageRequest;
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

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$package_max = \DB::table('package')->count('packageId');
        $package_max = $package_max + 1;
        $newId = 'PACKAGE'.str_pad($package_max, 4, '0', STR_PAD_LEFT); 
        $dateNow = date("Y-m-d");
    	$package = Package::with('product.product.product.types')->with('product.product.product.brand')->with('product.product.variance.unit')->with('service.service.categories')->get();
        $product = ProductVariance::with('product.types')->with('product.brand')->with('variance.unit')->get();
    	$service = Service::with('categories')->get();
        //$pp = PackageProduct::with('product.product.brand')->with('product.product.types')->with('product.variance.unit')->get();
        return view('Maintenance.Sales.package',compact('package','product','service','dateNow','newId'));
    }

    public function create(PackageRequest $request){
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
        if($prods!=null || $prods!=''){
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
        if($servs!=null || $servs!=''){
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
            \Session::flash('error_message','Package already exists. Update failed.');
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

    public function view(Request $request){
        $id = $request->input('id');
        $package = Package::with('product.product.product.types')->with('product.product.product.brand')->with('product.product.variance.unit')->with('service.service.categories')->where('packageId','=',$id)->get();
        return \Response::json(array('$package'=>$package));
    }
}
