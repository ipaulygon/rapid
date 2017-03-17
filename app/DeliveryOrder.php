<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    protected $table = 'delivery_order';
	protected $fillable = array(
								'deliveryOId',
								'deliveryOrderId',
								'deliveryOHeaderId',
								'deliveryOIsActive'
								//
								);
	public function header(){
		return $this->belongsTo('App\DeliveryHeader','deliveryOHeaderId');
	}
	public function order(){
		return $this->belongsTo('App\OrderSupplyHeader','deliveryOrderId');
	}
}
