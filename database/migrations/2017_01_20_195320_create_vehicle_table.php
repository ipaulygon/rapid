<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('vehicleId');
            $table->string('vehiclePlate');
            $table->string('vehicleMakeId');
            $table->string('vehicleModelId');
            $table->string('vehicleYear');
            $table->integer('vehicleType');
            $table->integer('vehicleEngine');
            $table->double('vehicleMileage', 15, 8)->nullable();
            $table->boolean('vehicleIsActive');
            $table->primary('vehicleId');
            $table->timestamps();
            $table->foreign('vehicleMakeId')
                  ->references('makeId')->on('vehicle_make')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('vehicleModelId')
                  ->references('modelId')->on('vehicle_model')
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
        Schema::dropIfExists('vehicle');
    }
}
