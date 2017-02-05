<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspectHeader extends Model
{
    protected $table = 'inspect_header';
    public $incrementing = false;
    protected $primaryKey = 'inspectHId';
	protected $fillable = array(
								'inspectHId',
								'inspectVehicleId',
								'inspectCustomerId',
								'inspectProblem',
								'inspectRequest',
								'inspectRemarks',
								'inspectIsActive'
								//
								);
	public function details(){
		return $this->hasMany('App\InspectDetail','inspectHDId');
	}
}
