<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    public $incrementing = false;
    protected $primaryKey = 'productId';
	protected $fillable = array(
								'productId',
								'productBrandId',
								'productName',
								'productTypeId',
								'productDesc',
								'productIsActive'
								//
								);
	public function types(){
		return $this->belongsTo('App\ProductType','productTypeId');
	}
	public function variance(){
		return $this->hasMany('App\ProductVariance','pvProductId');
	}
	public function brand(){
		return $this->belongsTo('App\Brand','productBrandId');	
	}
}
