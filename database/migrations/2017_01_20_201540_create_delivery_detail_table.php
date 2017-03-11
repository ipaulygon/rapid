<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_detail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('deliveryHDId');
            $table->unsignedInteger('deliveryDVarianceId');
            $table->integer('deliveryDQty');
            $table->text('deliveryDRemarks');
            $table->foreign('deliveryHDId')
                  ->references('deliveryHId')->on('delivery_header')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('deliveryDVarianceId')
                  ->references('pvId')->on('product_variance')
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
        Schema::dropIfExists('delivery_detail');
    }
}
