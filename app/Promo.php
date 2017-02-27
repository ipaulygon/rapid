<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promo';
    public $incrementing = false;
    protected $primaryKey = 'promoId';
	protected $fillable = array(
								'promoId',
								'promoName',
								'promoDesc',
								'promoStart',
								'promoEnd',
								'promoCost',
								'promoSupplies',
								'promoIsActive',
								'promoType'
								//
								);
	public function product(){
		return $this->hasMany('App\PromoProduct','promoPId');
	}
	public function service(){
		return $this->hasMany('App\PromoService','promoSId');
	}
}
