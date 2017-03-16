<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstimateProduct extends Model
{
    protected $table = 'estimate_product';
    public $incrementing = false;
    protected $primaryKey = ['estimatePId','estimateProductId'];
	protected $fillable = array(
								'estimatePId',
								'estimateProductId',
								'estimatePQty',
								//
								);
	public function header(){
		return $this->belongsTo('App\EstimateHeader','estimatePId');
	}
    public function product(){
		return $this->belongsTo('App\ProductVariance','estimateProductId');
	}
}
