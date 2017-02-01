<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discount';
    public $incrementing = false;
    protected $primaryKey = 'discountId';
	protected $fillable = array(
								'discountId',
								'discountName',
								'discountRate',
								'discountIsActive'
								//
								);
}
