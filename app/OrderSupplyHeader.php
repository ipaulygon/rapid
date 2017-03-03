<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderSupplyHeader extends Model
{
    protected $table = 'purchase_header';
    public $incrementing = false;
    protected $primaryKey = 'purchaseHId';
	protected $fillable = array(
								'purchaseHId',
								'purchaseHSupplierId',
								'purchaseHIsActive',
								'purchaseHDesc'
								//
								);
	public function supplier(){
		return $this->belongsTo('App\Supplier','purchaseHSupplierId');
	}
	public function detail(){
		return $this->hasMany('App\OrderSupplyDetail','purchaseHDId');
	}
}
