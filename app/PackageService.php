<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageService extends Model
{
    protected $table = 'package_service';
    public $incrementing = false;
    protected $primaryKey = 'packageSId';
	protected $fillable = array(
								'packageSId',
								'packageServiceId',
								'packageSIsActive'
								//
								);
	public function service(){
		return $this->belongsTo('App\Service','packageServiceId');
	}
}
