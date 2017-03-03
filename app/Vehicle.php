<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicle';
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
	public function make(){
		return $this->belongsTo('App\VehicleMake','vehicleMakeId');
	}
	public function model(){
		return $this->belongsTo('App\VehicleModel','vehicleModelId');
	}
}
