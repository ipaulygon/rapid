<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('estimatePId');
            $table->unsignedInteger('estimateProductId');
            $table->integer('estimatePQty');
            $table->primary(['estimatePId','estimateProductId']);
            $table->foreign('estimatePId')
                  ->references('estimateHId')->on('estimate_header')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('estimateProductId')
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
        Schema::dropIfExists('estimate_product');
    }
}
