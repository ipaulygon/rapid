<?php

namespace App\Http\Controllers;
use App\VehicleMake;
use App\VehicleModel;
use App\Vehicle;
use App\EstimateHeader;
use App\EstimateProduct;
use App\EstimateService;
use App\Customer;
use App\Package;
use App\Promo;
use App\Product;
use App\ProductType;
use App\Brand;
use App\Variance;
use App\Unit;
use App\ProductVariance;
use App\TypeVariance;
use App\Service;
use App\ServiceCategory;
use App\JobOrder;
use App\JobProduct;
use App\JobService;
use App\Invoice;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        // $jobs = EstimateHeader::with('customer')->with('vehicle')->get();
        $jobs = JobOrder::with('customer')->with('vehicle')->get();
    	return view('Transaction.payment',compact('jobs'));
    }

    public function createForm(){
        $invoice_max = \DB::table('invoice')->count('invoiceId');
        $invoice_max = $invoice_max + 1;
        $newId = 'INV'.str_pad($invoice_max, 5, '0', STR_PAD_LEFT); 
        $dateNow = date("Y-m-d");
        $vehicle = Vehicle::with('make')->with('model')->where('vehicleIsActive','=',1)->get();
        $make = VehicleMake::get();
        $model = VehicleModel::get();
        $customer = Customer::get();
        $promo = Promo::with('product.product.product.types')->with('product.product.product.brand')->with('product.product.variance.unit')->with('service.service.categories')->get();
        $package = Package::with('product.product.product.types')->with('product.product.product.brand')->with('product.product.variance.unit')->with('service.service.categories')->get();
        $products = ProductVariance::with('product.types')->with('product.brand')->with('variance.unit')->get();
        $service = Service::with('categories')->get();
        //$pp = PackageProduct::with('product.product.brand')->with('product.product.types')->with('product.variance.unit')->get();
        return view('Transaction.payment-form',compact('vehicle','make','model','customer','promo','package','products','service','dateNow','newId'));
    }

    public function create(){
        \Session::flash('flash_message','Job successfully added.');
        return redirect('transaction/payment');
    }
}
