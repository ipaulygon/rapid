<?php

namespace App\Http\Controllers;
use App\Http\Requests\PromoRequest;
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
use App\PromoProduct;
use App\PromoService;

use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$promo = Promo::with('product.product.product.types')->with('product.product.product.brand')->with('product.product.variance.unit')->with('service.service.categories')->get();
        $product = ProductVariance::with('product.types')->with('product.brand')->with('variance.unit')->get();
    	$service = Service::with('categories')->get();
        return view('Maintenance.Sales.promo',compact('newId','dateNow','promo','product','service'));
    }

    public function createForm(){
        $promo_max = \DB::table('promo')->count('promoId');
        $promo_max = $promo_max + 1;
        $newId = 'PROMO'.str_pad($promo_max, 4, '0', STR_PAD_LEFT); 
        $dateNow = date("Y-m-d");
        $promo = Promo::with('product.product.product.types')->with('product.product.product.brand')->with('product.product.variance.unit')->with('service.service.categories')->get();
        $product = ProductVariance::with('product.types')->with('product.brand')->with('variance.unit')->get();
        $service = Service::with('categories')->get();
        return view('Maintenance.Sales.promo_form',compact('promo','product','service','dateNow','newId'));
    }

    public function create(PromoRequest $request){
        $promoStart = trim($request->input('promoStart'));
        $promoEnd = trim($request->input('promoEnd'));
        $promoSupplies = trim($request->input('promoSupplies'));
        if($promoStart=='' || $promoStart==null){
            $promoStart = null;
        }
        if($promoEnd=='' || $promoEnd==null){
            $promoEnd = null;
        }
        if($promoSupplies=='' || $promoSupplies==null){
            $promoSupplies = null;
        }
        $promo = Promo::create(array(
                'promoId' => $request->input('promoId'),
                'promoName' => trim($request->input('promoName')),
                'promoDesc' => trim($request->input('promoDesc')),
                'promoStart' => $promoStart,
                'promoEnd' => $promoEnd,
                'promoCost' => trim($request->input('promoCost')),
                'promoSupplies' => $promoSupplies,
                'promoType' => trim($request->input('promoType')),
                'promoIsActive' => 1
            ));
        $promo->save();
        $prod = $request->input('promoProductId');
        $prods = explode(",", $prod);
        $serv = $request->input('promoServiceId');
        $servs = explode(",", $serv);
        $qty = $request->input('qty');
        if($prod!=null || $prod!=''){
            $x = 0;
            foreach ($prods as $prods) {
                $pp = PromoProduct::create(array(
                    'promoPId' => $request->input('promoId'),
                    'promoProductId' => $prods,
                    'promoPQty' => $qty[$x],
                    'promoPIsActive' => 1
                    ));
                $pp->save();
                $x++;
            }
        }
        if($serv!=null || $serv!=''){
            foreach ($servs as $servs) {
                $ps = PromoService::create(array(
                    'promoSId' => $request->input('promoId'),
                    'promoServiceId' => $servs,
                    'promoSIsActive' => 1
                    ));
                $ps->save();
            }
        }
        \Session::flash('flash_message','Promo successfully added.');
        return redirect('maintenance/promo');
    }

    public function update(Request $request){
        $this->validate($request, [
            'editPromoName' => 'required',
            'editPromoCost' => 'numeric|required',
            'editPromoSupplies' => 'numeric',
            'editPromoStart' => 'date',
            'editPromoEnd' => 'date'
        ]);
        $checkPromo = Promo::all();
        $isAdded = false;
        foreach ($checkPromo as $promo) {
            if(!strcasecmp($promo->promoId, $request->input('editPromoId')) == 0 
                && strcasecmp($promo->promoName, trim($request->input('editPromoName'))) == 0){
                $isAdded = true;
            }
        }
        if(!$isAdded){
            $promoStart = trim($request->input('editPromoStart'));
            $promoEnd = trim($request->input('editPromoEnd'));
            $promoSupplies = trim($request->input('editPromoSupplies'));
            if($promoStart=='' || $promoStart==null){
                $promoStart = null;
            }
            if($promoEnd=='' || $promoEnd==null){
                $promoEnd = null;
            }
            if($promoSupplies=='' || $promoSupplies==null){
                $promoSupplies = null;
            }
            $promo = Promo::find($request->input('editPromoId'));
            $promo->promoName = trim($request->input('editPromoName'));
            $promo->promoDesc = trim($request->input('editPromoDesc'));
            $promo->promoStart = $promoStart;
            $promo->promoCost = trim($request->input('editPromoCost'));
            $promo->promoEnd = $promoEnd;
            $promo->promoType = trim($request->input('editPromoType'));
            $promo->promoSupplies = $promoSupplies;
            $promo->save();
            $prod = $request->input('editPromoProductId');
            $prods = explode(",", $prod);
            $serv = $request->input('editPromoServiceId');
            $servs = explode(",", $serv);
            $qty = $request->input('qtys');
            $affectedRows = PromoProduct::where('promoPId', '=', $request->input('editPromoId'))->update(['promoPIsActive' => 0]);
            if($prod!=null || $prod!=''){
                $x = 0;
                foreach ($prods as $prods) {
                    $pp = PromoProduct::create(array(
                        'promoPId' => $request->input('editPromoId'),
                        'promoProductId' => $prods,
                        'promoPQty' => $qty[$x],
                        'promoPIsActive' => 1
                        ));
                    $pp->save();
                    $x++;
                }
            }
            $affectedRows = PromoService::where('promoSId', '=', $request->input('editPromoId'))->update(['promoSIsActive' => 0]);
            if($serv!=null || $serv!=''){
                $x = 0;
                foreach ($servs as $servs) {
                    $ps = PromoService::create(array(
                        'promoSId' => $request->input('editPromoId'),
                        'promoServiceId' => $servs,
                        'promoSIsActive' => 1
                        ));
                    $ps->save();
                    $x++;
                }
            }
            \Session::flash('flash_message','Promo successfully updated.');
        }else{
            \Session::flash('error_message','Promo already exists. Update failed.');
        }
        return redirect('maintenance/promo');
    }

    public function destroy(Request $request){
        $id = $request->input('delPromoId');
        $promo = Promo::find($request->input('delPromoId'));
        $promo->promoIsActive = 0;
        $promo->save();
        \Session::flash('flash_message','Promo successfully deleted.');
        return redirect('maintenance/promo');
    }

    public function view($id){
        $promo = Promo::with('product.product.product.types')->with('product.product.product.brand')->with('product.product.variance.unit')->with('service.service.categories')->where('promoId','=',$id)->get();
        $product = ProductVariance::with('product.types')->with('product.brand')->with('variance.unit')->get();
        $service = Service::with('categories')->get();
        $pp = PromoProduct::with('product.product.brand')->with('product.product.types')->with('product.variance.unit')->where('promoPId','=',$id)->get();
        $pd = PromoProduct::with('product.product.brand')->with('product.product.types')->with('product.variance.unit')->where('promoPId','=',$id)->get();
        $ps = PromoService::with('service.categories')->where('promoSId','=',$id)->get();
        return view('Maintenance.Sales.promo_update',compact('promo','product','service','pp','ps','pd'));
        //return \Response::json(array('$promo'=>$promo));
    }
}
