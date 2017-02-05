<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspectType extends Model
{
    protected $table = 'inspect_type';
    public $incrementing = false;
    protected $primaryKey = 'inspectTypeId';
	protected $fillable = array(
								'inspectTypeId',
								'inspectTypeName',
								'inspectTypeDesc',
								'inspectTypeIsActive'
								//
								);
	public function item(){
		return $this->hasMany('App\InspectItem','inspectItemTypeId');
	}
}
