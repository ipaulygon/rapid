<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';
    public $incrementing = false;
    protected $primaryKey = 'invoiceId';
	protected $fillable = array(
								'invoiceId',
								'invoiceJobId',
								'invoiceDiscountId',
								//
								);
}
