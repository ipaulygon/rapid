<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoProduct extends Model
{
    protected $table = 'promo_product';
    public $incrementing = false;
    protected $primaryKey = 'promoPId';
	protected $fillable = array(
								'promoPId',
								'promoProductId',
								'promoPQty',
								'promoPIsActive',
								'promoPIsFree'
								//
								);
	public function product(){
		return $this->belongsTo('App\ProductVariance','promoProductId');
	}
}
