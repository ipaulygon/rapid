<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicle';
    public $incrementing = false;
    protected $primaryKey = 'vehicleId';
	protected $fillable = array(
								'vehicleId',
								'vehiclePlate',
								'vehicleMakeId',
								'vehicleModelId',
								'vehicleYear',
								'vehicleType',
								'vehicleEngine',
								'vehicleMileage',
								'vehicleIsActive'
								//
								);
}
