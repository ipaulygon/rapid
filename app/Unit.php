<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';
    public $incrementing = false;
    protected $primaryKey = 'unitId';
	protected $fillable = array(
								'unitId',
								'unitName',
								'unitDesc',
								'unitIsActive'
								//
								);
}
