<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeVarianceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_variance', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('tvId');
            $table->string('tvTypeId');
            $table->string('tvVarianceId');
            $table->tinyInteger('tvIsActive');
            $table->timestamps();
            $table->foreign('tvTypeId')
                  ->references('typeId')->on('product_type')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('tvVarianceId')
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
        Schema::dropIfExists('type_variance');
    }
}
