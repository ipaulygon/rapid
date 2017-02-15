<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_service', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('promoSId');
            $table->string('promoServiceId');
            $table->boolean('promoSIsActive');
            $table->timestamps();
            $table->primary(['promoSId','promoServiceId']);
            $table->foreign('promoSId')
                  ->references('promoId')->on('promo')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('promoServiceId')
                  ->references('serviceId')->on('service')
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
        Schema::dropIfExists('promo_service');
    }
}
