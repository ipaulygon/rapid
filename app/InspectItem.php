<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspectItem extends Model
{
    protected $table = 'inspect_item';
    public $incrementing = false;
    protected $primaryKey = 'inspectItemId';
	protected $fillable = array(
								'inspectItemId',
								'inspectItemTypeId',
								'inspectItemName',
								'inspectItemDesc',
								'inspectItemIsActive'
								//
								);
	public function type(){
		return $this->belongsTo('App\InspectType','inspectItemTypeId');
	}
}
