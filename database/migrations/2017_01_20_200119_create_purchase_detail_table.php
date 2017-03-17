<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_detail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('purchaseHDId');
            $table->unsignedInteger('purchaseDVarianceId');
            $table->integer('purchaseDQty');
            $table->integer('purchaseDeliveredQty');
            $table->text('purchaseDRemarks')->nullable();
            $table->timestamps();
            $table->foreign('purchaseHDId')
                  ->references('purchaseHId')->on('purchase_header')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('purchaseDVarianceId')
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
        Schema::dropIfExists('purchase_detail');
    }
}
