<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    public $incrementing = false;
    protected $primaryKey = 'customerId';
	protected $fillable = array(
								'customerId',
								'customerFirst',
								'customerMiddle',
								'customerLast',
								'customerAddress',
								'customerEmail',
								'customerContact',
								'customerIsActive'
								//
								);
	public function inspect(){
		return $this->hasMany('App\InspectHeader','inspectCustomerId');
	}
    public function estimate(){
		return $this->hasMany('App\EstimateHeader','estimateHCustomerId');
	}
}
