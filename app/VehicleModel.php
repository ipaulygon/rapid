<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $table = 'vehicle_model';
    public $incrementing = false;
    protected $primaryKey = 'modelId';
	protected $fillable = array(
								'modelId',
								'modelName',
								'modelIsActive'
								//
								);
}
