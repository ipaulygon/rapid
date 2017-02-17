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
    	$promo_max = \DB::table('promo')->count('promoId');
        $promo_max = $promo_max + 1;
        $newId = 'PROMO'.str_pad($promo_max, 4, '0', STR_PAD_LEFT); 
        $dateNow = date("Y-m-d");
    	$promo = Promo::with('product.product.product.types')->with('product.product.product.brand')->with('product.product.variance.unit')->with('service.service.categories')->get();
        $product = ProductVariance::with('product.types')->with('product.brand')->with('variance.unit')->get();
    	$service = Service::with('categories')->get();
        //$pp = PromoProduct::with('product.product.brand')->with('product.product.types')->with('product.variance.unit')->get();
        return view('Maintenance.Sales.promo',compact('promo','product','service','dateNow','newId'));
    }

    public function create(PromoRequest $request){
        $end = trim($request->input('promoEnd'));
        if($end=='' || $end==null){
            $end = null;
        }
        $promo = Promo::create(array(
                'promoId' => $request->input('promoId'),
                'promoName' => trim($request->input('promoName')),
                'promoDesc' => trim($request->input('promoDesc')),
                'promoStart' => trim($request->input('promoStart')),
                'promoEnd' => $end,
                'promoCost' => trim($request->input('promoCost')),
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
            'editPromoStart' => 'required',
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
            $end = trim($request->input('editPromoEnd'));
            if($end=='' || $end==null){
                $end = null;
            }
            $promo = Promo::find($request->input('editPromoId'));
            $promo->promoName = trim($request->input('editPromoName'));
            $promo->promoDesc = trim($request->input('editPromoDesc'));
            $promo->promoStart = trim($request->input('editPromoStart'));
            $promo->promoCost = trim($request->input('editPromoCost'));
            $promo->promoEnd = $end;
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

    public function view(Request $request){
        $id = $request->input('id');
        $promo = Promo::with('product.product.product.types')->with('product.product.product.brand')->with('product.product.variance.unit')->with('service.service.categories')->where('promoId','=',$id)->get();
        return \Response::json(array('$promo'=>$promo));
    }
}
