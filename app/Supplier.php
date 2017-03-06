<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    public $incrementing = false;
    protected $primaryKey = 'supplierId';
	protected $fillable = array(
								'supplierId',
								'supplierName',
								'supplierPerson',
								'supplierContact',
								'supplierAddress',
								'supplierIsActive'
								//
								);
}
