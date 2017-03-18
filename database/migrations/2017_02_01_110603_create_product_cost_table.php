<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_cost', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('pcId');
            $table->double('pcCost',10,2);
            $table->timestamps();
            $table->primary(['pcId','pcCost','created_at']);
            $table->foreign('pcId')
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
        Schema::dropIfExists('product_cost');
    }
}
