<?php

namespace App\Http\Controllers;
use App\Http\Requests\PromoRequest;
use App\Promo;

use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	//smartCounter
        $ids = \DB::table('promo')
            ->select('promoId')
            ->orderBy('created_at', 'desc')
            ->orderBy('promoId', 'desc')
            ->take(1)
            ->get();
        $id = $ids["0"]->promoId;
        $newId = $this->smartCounter($id);
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

    public function add(){
        
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
