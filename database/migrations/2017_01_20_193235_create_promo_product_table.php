<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('promoPId');
            $table->unsignedInteger('promoProductId');
            $table->integer('promoPQty');
            $table->primary(['promoPId','promoProductId']);
            $table->foreign('promoPId')
                  ->references('promoId')->on('promo')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('promoProductId')
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
        Schema::dropIfExists('promo_product');
    }
}
