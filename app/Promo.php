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
								'promoIsActive'
								//
								);
}
