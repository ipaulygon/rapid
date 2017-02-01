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
        $ids = \DB::table('service_category')
            ->select('categoryId')
            ->orderBy('created_at', 'desc')
            ->orderBy('categoryId', 'desc')
            ->take(1)
            ->get();
        $id = $ids["0"]->categoryId;
        $newId = $this->smartCounter($id);
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
        \Session::flash('flash_message','ServiceCategory successfully deleted.');
        return redirect('maintenance/service-category');
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