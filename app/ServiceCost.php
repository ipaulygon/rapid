<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCost extends Model
{
    protected $table = 'service_cost';
    public $incrementing = false;
    protected $primaryKey = ('scId');
	protected $fillable = array(
								'scId',
								'scCost',
								//
								);
}
