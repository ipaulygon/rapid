<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Technician;
use App\TechSkill;
use App\Service;
use Validator;
use Redirect;

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
        $newId = 'TECH'.str_pad($tech_max, 4, '0', STR_PAD_LEFT); 
        $technician = Technician::with('skill.skill')->get();
        $skills = Service::get();
    	return view('Maintenance.technician',compact('technician','skills','newId'));
    }

    public function create(Request $request){
        $rules = array(
            'techPic' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'techFirst' => 'required|unique_with:technician,techMiddle,techLast',
            'techLast' => 'required',
            'street' => 'required',
            'brgy' => 'required',
            'city' => 'required',
            'techContact' => 'required|regex:/^\d{11}$/',
            'techEmail' => 'email',
        );
        $messages = [
            'unique' => ':attribute already exists.',
            'required' => 'The :attribute field is required.',
            'mimes' => 'The :attribute must be jpeg,png,jpg or svg',
            'max' => 'Max size is 2048',
            'email' => ':attribute must be email'
        ];
        $niceNames = array(
            'techPic' => 'Picture',
            'techFirst' => 'First Name',
            'techLast' => 'Last Name',
            'street' => 'Street',
            'brgy' => 'Barangay',
            'city' => 'City',
            'techContact' => 'Contact Number',
            'techEmail' => 'Email',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            \Session::flash('new_error','Error');
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $file = $request->file('techPic');
        $id = $request->input('techId');
        $techPic = "";
        if($file == '' || $file == null){
            $techPic = "pics/steve1.jpg";
        }else{
            $date = date("Ymdhis");
            $extension = $request->file('techPic')->getClientOriginalExtension();
            $techPic = "pics/".$date.$id.'.'.$extension;
            $request->file('techPic')->move("pics",$techPic);    
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
        $skill = $request->input('techSkillId');
        $skills = explode(',', $skill);
        if($skill!=null || $skill!=''){
            foreach($skills as $skills) {
                $ts = TechSkill::create(array(
                    'tsTechId' => $id,
                    'tvSkillId' => $skills,
                    'tsIsActive' => 1
                    ));
                $ts->save();
            }
        }
        \Session::flash('flash_message','Technician successfully added.');
        return redirect('maintenance/technician');
    }

    public function update(Request $request){
        $eid = $request->input('editTechId');
        $rules = array(
            'editTechPic' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'editTechFirst' => 'required',
            'editTechLast' => 'required',
            'editStreet' => 'required',
            'editBrgy' => 'required',
            'editCity' => 'required',
            'editTechContact' => 'required|numeric|regex:/^\d{11}$/',
            'editTechEmail' => 'email',
        );
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'The :attribute must be jpeg,png,jpg or svg',
            'max' => 'Max size is 2048',
            'email' => ':attribute must be email'
        ];
        $niceNames = array(
            'editTechPic' => 'Picture',
            'editTechFirst' => 'First Name',
            'editTechLast' => 'Last Name',
            'editStreet' => 'Street',
            'editBrgy' => 'Barangay',
            'editCity' => 'City',
            'editTechContact' => 'Contact Number',
            'editTechEmail' => 'Email',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            \Session::flash('update_error',$eid);
            return Redirect::back()->withErrors($validator);
        }
        $checktechs = Technician::all();
        $isAdded = false;
        $file = $request->file('editTechPic');
        $id = $request->input('editTechId');
        $techPic = "";
        foreach ($checktechs as $tech) {
            if(!strcasecmp($tech->techId, $request->input('editTechId')) == 0 
                && strcmp($tech->techFirst, trim($request->input('editTechFirst'))) == 0
                && strcmp($tech->techMiddle, trim($request->input('editTechMiddle'))) == 0
                && strcmp($tech->techLast, trim($request->input('editTechLast'))) == 0){
                $isAdded = true;
            }
        }
        if(!$isAdded){
            if($file == '' || $file == null){
                $techPic = $request->input('currentPic');
            }
            else{
                $date = date("Ymdhis");
                $extension = $request->file('editTechPic')->getClientOriginalExtension();
                $techPic = "pics/".$date.$id.'.'.$extension;
                $request->file('editTechPic')->move("pics",$techPic); 
            }
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
            $affectedRows = TechSkill::where('tsTechId', '=', $id)->update(['tsIsActive' => 0]);
            $skill = $request->input('editTechSkillId');
            $skills = explode(',', $skill);
            if($skill!=null || $skill!=''){
                foreach($skills as $skills) {
                    $ts = TechSkill::create(array(
                        'tsTechId' => $id,
                        'tsSkillId' => $skills,
                        'tsIsActive' => 1
                        ));
                    $ts->save();
                }
            }
            \Session::flash('flash_message','Technician successfully updated.');
        }else{
            \Session::flash('update_error',$eid);
            \Session::flash('update_unique','Error');
            return Redirect::back()->withErrors($validator)->withInput();
        }
        return redirect('maintenance/technician');
    }

    public function destroy(Request $request){
        $id = $request->input('delTechId');
        $tech = Technician::find($request->input('delTechId'));
        $tech->techIsActive = 0;
        $tech->save();
        $techSkill = TechSkill::where('tsTechId', '=', $id)->update(['tsIsActive' => 0]);
        \Session::flash('flash_message','Technician successfully deactivated.');
        return redirect('maintenance/technician');
    }
}
