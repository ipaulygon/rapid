<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $table = 'service_category';
    public $incrementing = false;
    protected $primaryKey = 'categoryId';
	protected $fillable = array(
								'categoryId',
								'categoryName',
								'categoryDesc',
								'categoryIsActive'
								//
								);
}
