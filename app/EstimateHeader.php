<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstimateHeader extends Model
{
    protected $table = 'estimate_header';
    public $incrementing = false;
    protected $primaryKey = 'estimateHId';
	protected $fillable = array(
								'estimateHId',
								'estimateHVehicleId',
								'estimateHCustomerId',
								//
								);
	public function vehicle(){
		return $this->belongsTo('App\Vehicle','estimateVehicleId');
	}
    public function customer(){
		return $this->belongsTo('App\Customer','estimateCustomerId');
	}
	public function product(){
		return $this->hasMany('App\EstimateProduct','estimateProductId');
	}
    public function service(){
		return $this->hasMany('App\EstimateService','estimateServiceId');
	}
}
