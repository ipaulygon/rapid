<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'service';
    public $incrementing = false;
    protected $primaryKey = 'serviceId';
	protected $fillable = array(
								'serviceId',
								'serviceName',
								'serviceCategoryId',
								'serviceDesc',
								'servicePrice',
								'serviceIsActive'
								//
								);
	public function categories()
	{
		return $this->belongsTo('App\ServiceCategory','serviceCategoryId');
	}
	public function skill(){
		return $this->hasMany('App\TechSkill','tsSkillId');
	}
}
