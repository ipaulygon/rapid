<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobProduct extends Model
{
    protected $table = 'job_product';
    public $incrementing = false;
    protected $primaryKey = ['jobPId','jobProductId'];
	protected $fillable = array(
								'jobPId',
								'jobProductId',
								'jobPQty',
								//
								);
	public function header(){
		return $this->belongsTo('App\JobOrder','jobPId');
	}
    public function product(){
		return $this->belongsTo('App\ProductVariance','jobProductId');
	}
}
