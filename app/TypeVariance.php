<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeVariance extends Model
{
    protected $table = 'type_variance';
    protected $primaryKey = 'tvId';
	protected $fillable = array(
								'tvId',
								'tvTypeId',
								'tvVarianceId',
								'tvIsActive'
								//
								);
	public function type(){
		return $this->belongsTo('App\ProductType','tvTypeId');
	}
	public function variance(){
		return $this->belongsTo('App\Variance','tvVarianceId');
	}
}
