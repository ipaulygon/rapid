<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderSupplyDetail extends Model
{
    protected $table = 'purchase_detail';
    public $incrementing = false;
	protected $fillable = array(
								'purchaseHDId',
								'purchaseDVarianceId',
								'purchaseDQty',
								'purchaseDeliveredQty',
								'purchaseDRemarks'
								//
								);
	public function header(){
		return $this->belongsTo('App\OrderSupplyHeader','purchaseHDId');
	}
	public function variance(){
		return $this->belongsTo('App\ProductVariance','purchaseDVarianceId');
	}
}
