<?php

namespace App\Http\Controllers;
use App\Http\Requests\TechRequest;
use App\Technician;

use Illuminate\Http\Request;

class TechController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $tech_max = \DB::table('technician')->count('techId');
        $tech_max = $tech_max + 1;
        $newId = 'TECH'.str_pad($brand_max, 4, '0', STR_PAD_LEFT); 
        $technician = Technician::get();
    	return view('Maintenance.technician',compact('technician','newId'));
    }

    public function create(TechRequest $request){
        $file = $request->file('techPic');
        $techPic = "";
        if($file == '' || $file == null){
            $techPic = "pics/steve1.jpg";
        }else{
            $techPic = "pics/".$request->file('techPic')->getClientOriginalName();
            $request->file('techPic')->move("pics",$request->file('techPic')->getClientOriginalName());    
        }
        $tech = Technician::create(array(
            'techId' => $request->input('techId'),
            'techFirst' => trim($request->input('techFirst')),
            'techMiddle' => trim($request->input('techMiddle')),
            'techLast' => trim($request->input('techLast')),
            'techStreet' => trim($request->input('street')),
            'techBrgy' => trim($request->input('brgy')),
            'techCity' => trim($request->input('city')),
            'techContact' => trim($request->input('techContact')),
            'techEmail' => trim($request->input('techEmail')),
            'techPic' => $techPic,
            'techIsActive' => 1
            ));
        $tech->save();
        \Session::flash('flash_message','Technician successfully added.');
        return redirect('maintenance/technician');
    }

    public function update(Request $request){
        $checktechs = Technician::all();
        $isAdded = false;
        $file = $request->file('editTechPic');
        $techPic = "";
        if($file == '' || $file == null){
            $techPic = $request->input('currentPic');
        }
        else{
            $techPic = "pics/".$request->file('editTechPic')->getClientOriginalName();
            $request->file('editTechPic')->move("pics",$request->file('editTechPic')->getClientOriginalName());    
        }
        foreach ($checktechs as $tech) {
            if(!strcasecmp($tech->techId, $request->input('editTechId')) == 0 
                && strcmp($tech->techFirst, trim($request->input('editTechFirst'))) == 0
                && strcmp($tech->techMiddle, trim($request->input('editTechMiddle'))) == 0
                && strcmp($tech->techLast, trim($request->input('editTechLast'))) == 0){
                $isAdded = true;
            }
        }
        if(!$isAdded){
            $tech = Technician::find($request->input('editTechId'));
            $tech->techFirst = trim($request->input('editTechFirst'));
            $tech->techMiddle = trim($request->input('editTechMiddle'));
            $tech->techLast = trim($request->input('editTechLast'));
            $tech->techStreet = trim($request->input('editStreet'));
            $tech->techBrgy = trim($request->input('editBrgy'));
            $tech->techCity = trim($request->input('editCity'));
            $tech->techContact = trim($request->input('editTechContact'));
            $tech->techEmail = trim($request->input('editTechEmail'));
            $tech->techPic = $techPic;
            $tech->save();
            \Session::flash('flash_message','Technician successfully updated.');
        }else{
            \Session::flash('error_message','Technician already exists. Update failed.');
        }
        return redirect('maintenance/technician');
    }

    public function destroy(Request $request){
        $id = $request->input('delTechId');
        $tech = Technician::find($request->input('delTechId'));
        $tech->techIsActive = 0;
        $tech->save();
        \Session::flash('flash_message','Technician successfully deactivated.');
        return redirect('maintenance/technician');
    }
}
