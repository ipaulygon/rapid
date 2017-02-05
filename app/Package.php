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
								'packageStart',
								'packageEnd',
								'packageIsActive'
								//
								);
}
