<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_header', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('purchaseHId');
            $table->string('purchaseHSupplierId');
            $table->boolean('purchaseHIsActive');
            $table->text('purchaseHDesc');
            $table->timestamps();
            $table->primary('purchaseHId');
            $table->foreign('purchaseHSupplierId')
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
        Schema::dropIfExists('purchase_header');
    }
}
