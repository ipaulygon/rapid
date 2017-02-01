<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariance extends Model
{
    protected $table = 'product_variance';
    public $incrementing = false;
    protected $primaryKey = 'pvId';
	protected $fillable = array(
								'pvId',
								'pvProductId',
								'pvVarianceId',
								'pvDesc',
								'pvCost',
								'pvIsActive'
								//
								);
}
