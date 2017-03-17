<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    protected $table = 'job_order';
    public $incrementing = false;
    protected $primaryKey = 'jobId';
	protected $fillable = array(
								'jobId',
								'jobVehicleId',
								'jobCustomerId',
								'jobIsActive'
								//
								);
	public function vehicle(){
		return $this->belongsTo('App\Vehicle','jobVehicleId');
	}
    public function customer(){
		return $this->belongsTo('App\Customer','jobCustomerId');
	}
	public function product(){
		return $this->hasMany('App\JobProduct','jobProductId');
	}
    public function service(){
		return $this->hasMany('App\JobService','jobServiceId');
	}
}
