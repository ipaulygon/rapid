<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCost extends Model
{
    protected $table = 'product_cost';
    public $incrementing = false;
    protected $primaryKey = ('pcId');
	protected $fillable = array(
								'pcId',
								'pcCost',
								//
								);
}
