<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryHeader extends Model
{
    protected $table = 'delivery_header';
    public $incrementing = false;
    protected $primaryKey = 'deliveryHId';
	protected $fillable = array(
								'deliveryHId',
								'deliveryHSupplierId',
								'deliveryIsActive',
								//
								);
	public function supplier(){
		return $this->belongsTo('App\Supplier','deliveryHSupplierId');
	}
	public function detail(){
		return $this->hasMany('App\DeliveryDetail','deliveryHDId');
	}
}
