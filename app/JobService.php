<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobService extends Model
{
    protected $table = 'job_service';
    public $incrementing = false;
    protected $primaryKey = ['jobSId','jobServiceId'];
	protected $fillable = array(
								'jobSId',
								'jobServiceId',
								//
								);
	public function header(){
		return $this->belongsTo('App\JobOrder','jobSId');
	}
    public function service(){
		return $this->belongsTo('App\Service','jobServiceId');
	}
}
