<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimateHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_header', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('estimateHId');
            $table->string('estimateVehicleId');
            $table->string('estimateCustomerId');
            $table->timestamps();
            $table->primary('estimateHId');
            $table->foreign('estimateVehicleId')
                  ->references('vehicleId')->on('vehicle')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('estimateCustomerId')
                  ->references('customerId')->on('customer')
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
        Schema::dropIfExists('estimate_header');
    }
}
