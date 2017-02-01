<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_service', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('estimateSId');
            $table->string('estimateServiceId');
            $table->primary(['estimateSId','estimateServiceId']);
            $table->foreign('estimateSId')
                  ->references('estimateHId')->on('estimate_header')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('estimateServiceId')
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
        Schema::dropIfExists('estimate_service');
    }
}
