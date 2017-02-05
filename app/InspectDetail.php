<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InspectDetail extends Model
{
    protected $table = 'inspect_detail';
    public $incrementing = false;
    protected $primaryKey = 'inspectHDId';
	protected $fillable = array(
								'inspectHDId',
								'inspectItemDId',
								'inspectDRemarks',
								'inspectDRating',
								'inspectDCondition',
								//
								);
	public function header(){
		return $this->belongsTo('App\InspectHeader','inspectHDId');
	}
}
