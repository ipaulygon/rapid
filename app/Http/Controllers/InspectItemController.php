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
        $insitem_max = \DB::table('inspect_item')->count('inspectItemId');
        $insitem_max = $insitem_max + 1;
        $newIdItem = 'INSITEM'.str_pad($insitem_max, 4, '0', STR_PAD_LEFT); 
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
        $this->validate($request, [
            'editInspectItemName' => 'required',
            'editInspectItemTypeId' => 'required',
        ]);
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
            $inspectItem->inspectItemTypeId = trim($request->input('editInspectItemTypeId'));
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
        \Session::flash('flash_message','Inspection item successfully deactivated.');
        return redirect('maintenance/inspect-item');
    }
}
