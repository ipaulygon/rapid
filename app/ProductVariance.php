<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariance extends Model
{
    protected $table = 'product_variance';
    protected $primaryKey = 'pvId';
	protected $fillable = array(
								'pvId',
								'pvProductId',
								'pvVarianceId',
								'pvDesc',
								'pvCost',
								'pvIsActive'
								//
								);
	public function product(){
		return $this->belongsTo('App\Product','pvProductId');
	}
	public function variance(){
		return $this->belongsTo('App\Variance','pvVarianceId');
	}
}
