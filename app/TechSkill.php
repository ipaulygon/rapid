<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechSkill extends Model
{
    protected $table = 'tech_skill';
    protected $primaryKey = 'tsId';
	protected $fillable = array(
								'tsId',
								'tsTechId',
								'tsSkillId',
								'tsIsActive'
								//
								);
	public function tech(){
		return $this->belongsTo('App\Technician','tsTechId');
	}
	public function skill(){
		return $this->belongsTo('App\Service','tsSkillId');
	}
}
