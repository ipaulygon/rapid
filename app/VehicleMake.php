<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleMake extends Model
{
    protected $table = 'vehicle_make';
    public $incrementing = false;
    protected $primaryKey = 'makeId';
	protected $fillable = array(
								'makeId',
								'makeName',
								'makeIsActive'
								//
								);
}
