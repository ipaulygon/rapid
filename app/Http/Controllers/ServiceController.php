<?php

namespace App\Http\Controllers;
use App\Http\Requests\ServiceRequest;
use App\Service;
use App\ServiceCost;
use App\ServiceCategory;

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

    public function create(ServiceRequest $request){
        $serv = Service::create(array(
            'serviceId' => $request->input('serviceId'),
            'serviceName' => trim($request->input('serviceName')),
            'serviceCategoryId' => $request->input('serviceCategoryId'),
            'serviceDesc' => trim($request->input('serviceDesc')),
            'servicePrice' => trim($request->input('servicePrice')),
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
    	$checkService = Service::all();
        $isAdded = false;
        foreach ($checkService as $serv) {
        	if(!strcasecmp($serv->serviceId, $request->input('editServiceId')) == 0 
        		&& strcasecmp($serv->serviceName, trim($request->input('editServiceName'))) == 0){
        		$isAdded = true;
        	}
        }
        if(!$isAdded){
            $serv = Service::find($request->input('editServiceId'));
            $serv->serviceName = trim($request->input('editServiceName'));
            $serv->serviceDesc = trim($request->input('editServiceDesc'));
            $serv->serviceCategoryId = $request->input('editServiceCategoryId');
            $serv->servicePrice = trim($request->input('editServicePrice'));
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
            \Session::flash('error_message','Service already exists. Update failed.');
        }
        return redirect('maintenance/service');
    }

    public function destroy(Request $request){
        $id = $request->input('delServiceId');
        $serv = Service::find($request->input('delServiceId'));
        $serv->serviceIsActive = 0;
        $serv->save();
        \Session::flash('flash_message','Service successfully deleted.');
        return redirect('maintenance/service');
    }
}
