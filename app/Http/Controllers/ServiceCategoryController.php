<?php

namespace App\Http\Controllers;
use App\Http\Requests\ServiceCategoryRequest;
use App\ServiceCategory;

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

    public function create(ServiceCategoryRequest $request){
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
        $this->validate($request, [
            'editCategoryName' => 'required',
        ]);
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
            \Session::flash('error_message','Service Category already exists. Update failed.');
        }
        return redirect('maintenance/service-category');
    }

    public function destroy(Request $request){
        $id = $request->input('delCategoryId');
        $category = ServiceCategory::find($request->input('delCategoryId'));
        $category->categoryIsActive = 0;
        $category->save();
        \Session::flash('flash_message','ServiceCategory successfully deactivated.');
        return redirect('maintenance/service-category');
    }
}