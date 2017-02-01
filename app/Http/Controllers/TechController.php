<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TechController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        /*$ids = \DB::table('inspect_item')
        ->select('inspectItemId')
            ->orderBy('created_at', 'desc')
            ->orderBy('inspectItemId', 'desc')
            ->take(1)
            ->get();
        $id = $ids["0"]->inspectItemId;*/
        /*$newId = $this->smartCounter($id);*/
        $newId = "TECH001";
    	return view('Maintenance.technician',compact('newId'));
    }
}
