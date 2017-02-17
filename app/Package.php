<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'package';
    public $incrementing = false;
    protected $primaryKey = 'packageId';
	protected $fillable = array(
								'packageId',
								'packageName',
								'packageDesc',
								'packageCost',
								'packageIsActive'
								//
								);
	public function product(){
		return $this->hasMany('App\PackageProduct','packagePId');
	}
	public function service(){
		return $this->hasMany('App\PackageService','packageSId');
	}
}
