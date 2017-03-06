<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('supplierId');
            $table->string('supplierName');
            $table->string('supplierPerson');
            $table->string('supplierContact');
            $table->text('supplierAddress')->nullable();
            $table->boolean('supplierIsActive');
            $table->timestamps();
            $table->primary('supplierId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier');
    }
}
