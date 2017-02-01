<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variance extends Model
{
    protected $table = 'variance';
    public $incrementing = false;
    protected $primaryKey = 'varianceId';
	protected $fillable = array(
								'varianceId',
								'varianceDesc',
								'varianceSize',
								'varianceUnitId',
								'varianceIsActive'
								//
								);
	public function unit(){
		return $this->belongsTo('App\Unit','varianceUnitId');
	}
}
