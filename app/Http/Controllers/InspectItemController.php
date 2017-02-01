<?php

namespace App\Http\Controllers;
use App\Http\Requests\InspectItemRequest;
use App\InspectItem;
use App\InspectType;

use Illuminate\Http\Request;

class InspectItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $ids = \DB::table('inspect_item')
        ->select('inspectItemId')
            ->orderBy('created_at', 'desc')
            ->orderBy('inspectItemId', 'desc')
            ->take(1)
            ->get();
        $id = $ids["0"]->inspectItemId;
        $newIdItem = $this->smartCounter($id);
    	$inspect_item = InspectItem::with('type')->get();
    	$inspect_type = InspectType::get();
    	return view('Maintenance.Service.inspection_item',compact('inspect_item','newIdItem','inspect_type'));
    }

    public function create(InspectItemRequest $request){
        $type = InspectItem::create(array(
            'inspectItemId' => $request->input('inspectItemId'),
            'inspectItemName' => trim($request->input('inspectItemName')),
            'inspectItemDesc' => trim($request->input('inspectItemDesc')),
            'inspectItemTypeId' => trim($request->input('inspectItemTypeId')),
            'inspectItemIsActive' => 1
            ));
        $type->save();
        \Session::flash('flash_message','Inspection item successfully added.');
        return redirect('maintenance/inspect-item');
    }

    public function update(Request $request){
        $checkInspectItem = InspectItem::all();
        $isAdded = false;
        foreach ($checkInspectItem as $inspectItem) {
            if(!strcasecmp($inspectItem->inspectItemId, $request->input('editInspectItemId')) == 0 
                && strcasecmp($inspectItem->inspectItemName, trim($request->input('editInspectItemName'))) == 0
                && strcasecmp($inspectItem->inspectItemTypeId, trim($request->input('editInspectItemTypeId'))) == 0){
                $isAdded = true;
            }
        }
        if(!$isAdded){
            $inspectItem = InspectItem::find($request->input('editInspectItemId'));
            $inspectItem->inspectItemName = trim($request->input('editInspectItemName'));
            $inspectItem->inspectItemDesc = trim($request->input('editInspectItemDesc'));
            $inspectItem->inspectItemDesc = trim($request->input('editInspectItemTypeId'));
            $inspectItem->save();
            \Session::flash('flash_message','Inspection item successfully updated.');
        }else{
            \Session::flash('error_message','Inspection item already exists. Update failed.');
        }
        return redirect('maintenance/inspect-item');
    }

    public function destroy(Request $request){
        $id = $request->input('delInspectItemId');
        $inspectItem = InspectItem::find($request->input('delInspectItemId'));
        $inspectItem->inspectItemIsActive = 0;
        $inspectItem->save();
        \Session::flash('flash_message','Inspection item successfully deleted.');
        return redirect('maintenance/inspect-item');
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