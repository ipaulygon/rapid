<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVarianceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variance', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('pvId');
            $table->string('pvProductId');
            $table->string('pvVarianceId');
            $table->text('pvDesc')->nullable();
            $table->float('pvCost',8,2);
            $table->tinyInteger('pvIsActive');
            $table->timestamps();
            $table->primary('pvId');
            $table->foreign('pvProductId')
                  ->references('productId')->on('product')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('pvVarianceId')
                  ->references('varianceId')->on('variance')
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
        Schema::dropIfExists('product_variance');
    }
}
