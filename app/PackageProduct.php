<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageProduct extends Model
{
    protected $table = 'package_product';
    public $incrementing = false;
    protected $primaryKey = 'packagePId';
	protected $fillable = array(
								'packagePId',
								'packageProductId',
								'packagePQty',
								'packagePIsActive'
								//
								);
	public function product(){
		return $this->belongsTo('App\ProductVariance','packageProductId');
	}
}
