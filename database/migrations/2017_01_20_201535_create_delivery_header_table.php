<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_header', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('deliveryHId');
            $table->string('deliveryHSupplierId');
            $table->boolean('deliveryIsActive');
            $table->timestamps();
            $table->primary('deliveryHId');
            $table->foreign('deliveryHSupplierId')
                  ->references('supplierId')->on('supplier')
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
        Schema::dropIfExists('delivery_header');
    }
}
