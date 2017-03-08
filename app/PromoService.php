<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromoService extends Model
{
    protected $table = 'promo_service';
    public $incrementing = false;
    protected $primaryKey = 'promoSId';
	protected $fillable = array(
								'promoSId',
								'promoServiceId',
								'promoSIsActive',
								'promoSIsFree'
								//
								);
	public function service(){
		return $this->belongsTo('App\Service','promoServiceId');
	}
}
