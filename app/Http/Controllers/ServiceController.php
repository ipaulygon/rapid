<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Service;
use App\ServiceCost;
use App\ServiceCategory;
use App\PackageService;
use App\PromoService;
use App\TechSkill;
use Validator;
use Redirect;


use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $service_max = \DB::table('service')->count('serviceId');
        $service_max = $service_max + 1;
        $newId = 'SERV'.str_pad($service_max, 4, '0', STR_PAD_LEFT); 
    	$service = Service::with('categories')->get();
    	$category = ServiceCategory::get();
    	return view('Maintenance.Service.service',compact('service','category','newId'));
    }

    public function create(Request $request){
        $rules = array(
            'serviceName' => 'required|unique_with:service,serviceSize',
            'serviceCategoryId' => 'required',
            'serviceSize' => 'required',
            'servicePrice' => 'numeric|required|between:0,99999999.99'
        );
        $messages = [
            'unique' => ':attribute already exists.',
            'required' => 'The :attribute field is required.',
            'numeric' => 'The :attribute must be numeric'
        ];
        $niceNames = array(
            'serviceName' => 'Service',
            'serviceCategoryId' => 'Category Id',
            'serviceSize' => 'Size',
            'servicePrice' => 'Price'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            \Session::flash('new_error','Error');
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $serv = Service::create(array(
            'serviceId' => $request->input('serviceId'),
            'serviceName' => trim($request->input('serviceName')),
            'serviceCategoryId' => $request->input('serviceCategoryId'),
            'serviceDesc' => trim($request->input('serviceDesc')),
            'servicePrice' => trim($request->input('servicePrice')),
            'serviceSize' => trim($request->input('serviceSize')),
            'serviceIsActive' => 1
            ));
        $serv->save();
        $servCost = ServiceCost::create(array(
            'scId' => $request->input('serviceId'),
            'scCost' => trim($request->input('servicePrice'))
        ));
        $servCost->save();
        \Session::flash('flash_message','Service successfully added.');
        return redirect('maintenance/service');
    }

    public function update(Request $request){
        $eid = $request->input('editServiceId');
        $rules = array(
            'editServiceName' => 'required',
            'editServiceCategoryId' => 'required',
            'editServiceSize' => 'required',
            'editServicePrice' => 'numeric|required|between:0,99999999.99',
        );
        $messages = [
            'required' => 'The :attribute field is required.',
            'numeric' => 'The :attribute must be numeric'
        ];
        $niceNames = array(
            'editServiceName' => 'Service',
            'editServiceCategoryId' => 'Category Id',
            'editServiceSize' => 'Size',
            'editServicePrice' => 'Price'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            \Session::flash('update_error',$eid);
            return Redirect::back()->withErrors($validator);
        }
    	$checkService = Service::all();
        $isAdded = false;
        foreach ($checkService as $serv) {
        	if(!strcasecmp($serv->serviceId, $request->input('editServiceId')) == 0 
        		&& strcasecmp($serv->serviceName, trim($request->input('editServiceName'))) == 0
                && strcasecmp($serv->serviceSize, trim($request->input('editServiceSize'))) == 0){
        		$isAdded = true;
        	}
        }
        if(!$isAdded){
            $serv = Service::find($request->input('editServiceId'));
            $serv->serviceName = trim($request->input('editServiceName'));
            $serv->serviceDesc = trim($request->input('editServiceDesc'));
            $serv->serviceCategoryId = $request->input('editServiceCategoryId');
            $serv->servicePrice = trim($request->input('editServicePrice'));
            $serv->serviceSize = trim($request->input('editServiceSize'));
            $serv->save();
            if($serv->servicePrice!=$request->input('currentServicePrice')){
                $servCost = ServiceCost::create(array(
                    'scId' => $request->input('editServiceId'),
                    'scCost' => trim($request->input('editServicePrice'))
                ));
                $servCost->save();
            }
            \Session::flash('flash_message','Service successfully updated.');
        }else{
            \Session::flash('update_error',$eid);
            \Session::flash('update_unique','Error');
            return Redirect::back()->withErrors($validator)->withInput();
        }
        return redirect('maintenance/service');
    }

    public function destroy(Request $request){
        $id = $request->input('delServiceId');
        $package_service = PackageService::where('packageServiceId','=',$id)->where('packageSIsActive','=',1)->count();
        if($package_service>0){
            \Session::flash('error_message','Service is still being used in packages. Deactivation failed');
            return redirect('maintenance/service');
        }
        $promo_service = PromoService::where('promoServiceId','=',$id)->where('promoSIsActive','=',1)->count();
        if($promo_service>0){
            \Session::flash('error_message','Service is still being used in promos. Deactivation failed');
            return redirect('maintenance/service');
        }
        $tech_skill = TechSkill::where('tsSkillId','=',$id)->where('tsIsActive','=',1)->count();
        if($tech_skill>0){
            \Session::flash('error_message','Service is still being used in technician skills. Deactivation failed');
            return redirect('maintenance/service');
        }
        $serv = Service::find($request->input('delServiceId'));
        $serv->serviceIsActive = 0;
        $serv->save();
        \Session::flash('flash_message','Service successfully deactivated.');
        return redirect('maintenance/service');
    }
}
