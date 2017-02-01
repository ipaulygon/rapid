<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';
    public $incrementing = false;
    protected $primaryKey = 'brandId';
	protected $fillable = array(
								'brandId',
								'brandName',
								'brandDesc',
								'brandIsActive'
								//
								);
}
