<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_order', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('deliveryOId');
            $table->string('deliveryOSupplierId');
            $table->string('deliveryOHeaderId');
            $table->boolean('deliveryOIsActive');
            $table->timestamps();
            $table->foreign('deliveryOSupplierId')
                  ->references('supplierId')->on('supplier')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('deliveryOHeaderId')
                  ->references('deliveryHId')->on('delivery_header')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_order');
    }
}
