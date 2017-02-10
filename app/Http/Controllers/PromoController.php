<?php

namespace App\Http\Controllers;
use App\Http\Requests\PromoRequest;
use App\Promo;
use App\Product;
use App\ProductType;
use App\Brand;
use App\Variance;
use App\ProductVariance;
use App\TypeVariance;
use App\Service;
use App\ServiceCategory;

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
    	$promo = Promo::get();
    	return view('Maintenance.Sales.promo',compact('promo','dateNow','newId'));
    }

    public function create(PromoRequest $request){
        $promo = Promo::create(array(
                'promoId' => $request->input('promoId'),
                'promoName' => trim($request->input('promoName')),
                'promoDesc' => trim($request->input('promoDesc')),
                'promoStart' => trim($request->input('promoStart')),
                'promoEnd' => trim($request->input('promoEnd')),
                'promoIsActive' => 1
            ));
        $promo->save();

        \Session::flash('flash_message','Promo successfully added.');
        return redirect('maintenance/promo');
    }

    public function update(Request $request){
        $checkPromo = Promo::all();
        $isAdded = false;
        foreach ($checkPromo as $promo) {
            if(!strcasecmp($promo->promoId, $request->input('editPromoId')) == 0 
                && strcasecmp($promo->promoName, trim($request->input('editPromoName'))) == 0){
                $isAdded = true;
            }
        }
        if(!$isAdded){
            $promo = Promo::find($request->input('editPromoId'));
            $promo->promoName = trim($request->input('editPromoName'));
            $promo->promoDesc = trim($request->input('editPromoDesc'));
            $promo->promoStart = trim($request->input('editPromoStart'));
            $promo->promoEnd = trim($request->input('editPromoEnd'));
            $promo->save();
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
        \Session::flash('add_promo','Add items');
        return redirect('maintenance/promo');
    }
}
