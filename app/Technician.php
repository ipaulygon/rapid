<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    protected $table = 'technician';
    public $incrementing = false;
    protected $primaryKey = 'techId';
	protected $fillable = array(
								'techId',
								'techFirst',
								'techMiddle',
								'techLast',
								'techStreet',
								'techBrgy',
								'techCity',
								'techEmail',
								'techContact',
								'techPic',
								'techIsActive'
								//
								);
	public function skill(){
		return $this->hasMany('App\TechSkill','tsTechId');
	}
}
