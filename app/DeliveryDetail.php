<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryDetail extends Model
{
    protected $table = 'delivery_detail';
    public $incrementing = false;
	protected $fillable = array(
								'deliveryHDId',
								'deliveryDVarianceId',
								'deliveryDQty',
								'deliveryDRemarks'
								//
								);
	public function header(){
		return $this->belongsTo('App\DeliveryHeader','deliveryHDId');
	}
	public function variance(){
		return $this->belongsTo('App\ProductVariance','deliveryDVarianceId');
	}
}
