<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstimateService extends Model
{
    protected $table = 'estimate_service';
    public $incrementing = false;
    protected $primaryKey = ['estimateSId','estimateServiceId'];
	protected $fillable = array(
								'estimateSId',
								'estimateServiceId',
								//
								);
	public function header(){
		return $this->belongsTo('App\EstimateHeader','estimateSId');
	}
    public function service(){
		return $this->belongsTo('App\Service','estimateServiceId');
	}
}
