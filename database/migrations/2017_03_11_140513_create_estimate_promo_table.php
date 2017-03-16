<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimatePromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_promo', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('estimatePrId');
            $table->string('estimatePromoId');
            $table->integer('estimatePrQty');
            $table->primary(['estimatePrId','estimatePromoId']);
            $table->foreign('estimatePrId')
                  ->references('estimateHId')->on('estimate_header')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('estimatePromoId')
                  ->references('promoId')->on('promo')
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
        Schema::dropIfExists('estimate_promo');
    }
}
