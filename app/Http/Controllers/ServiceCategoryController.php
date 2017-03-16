<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\ServiceCategory;
use App\Service;
use Validator;
use Redirect;

use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $category_max = \DB::table('service_category')->count('categoryId');
        $category_max = $category_max + 1;
        $newId = 'SC'.str_pad($category_max, 3, '0', STR_PAD_LEFT); 
    	$service_category = ServiceCategory::get();
    	return view('Maintenance.Service.service_category',compact('service_category','newId'));
    }

    public function create(Request $request){
        $rules = array(
            'categoryName' => 'required|unique:service_category',
        );
        $messages = [
            'unique' => ':attribute already exists.',
            'required' => 'The :attribute field is required.',
        ];
        $niceNames = array(
            'categoryName' => 'Category',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            \Session::flash('new_error','Error');
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $type = ServiceCategory::create(array(
            'categoryId' => $request->input('categoryId'),
            'categoryName' => trim($request->input('categoryName')),
            'categoryDesc' => trim($request->input('categoryDesc')),
            'categoryIsActive' => 1
            ));
        $type->save();
        \Session::flash('flash_message','Service category successfully added.');
        return redirect('maintenance/service-category');
    }

    public function update(Request $request){
        $eid = $request->input('editCategoryId');
        $rules = array(
            'editCategoryName' => 'required',
        );
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $niceNames = array(
            'editCategoryName' => 'Category',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            \Session::flash('update_error',$eid);
            return Redirect::back()->withErrors($validator);
        }
        $checkCategory = ServiceCategory::all();
        $isAdded = false;
        foreach ($checkCategory as $category) {
            if(!strcasecmp($category->categoryId, $request->input('editCategoryId')) == 0 
                && strcasecmp($category->categoryName, trim($request->input('editCategoryName'))) == 0){
                $isAdded = true;
            }
        }
        if(!$isAdded){
            $category = ServiceCategory::find($request->input('editCategoryId'));
            $category->categoryName = trim($request->input('editCategoryName'));
            $category->categoryDesc = trim($request->input('editCategoryDesc'));
            $category->save();
            \Session::flash('flash_message','Service Category successfully updated.');
        }else{
            \Session::flash('update_error',$eid);
            \Session::flash('update_unique','Error');
            return Redirect::back()->withErrors($validator)->withInput();
        }
        return redirect('maintenance/service-category');
    }

    public function destroy(Request $request){
        $id = $request->input('delCategoryId');
        $service_category = Service::with('categories')->where('serviceCategoryId','=',$id)->count();
        if($service_category>0){
            \Session::flash('error_message','Category is still being used in services. Deactivation failed');
            return redirect('maintenance/service-category');
        }
        else{
            $category = ServiceCategory::find($request->input('delCategoryId'));
            $category->categoryIsActive = 0;
            $category->save();
            \Session::flash('flash_message','Service category successfully deactivated.');
            return redirect('maintenance/service-category');
        }
    }
}