<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'product_type';
    public $incrementing = false;
    protected $primaryKey = 'typeId';
	protected $fillable = array(
								'typeId',
								'typeName',
								'typeDesc',
								'typeIsActive'
								//
								);
}
