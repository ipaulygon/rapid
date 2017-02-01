<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_model', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('modelId');
            $table->string('modelName');
            $table->boolean('modelIsActive');
            $table->timestamps();
            $table->primary('modelId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_model');
    }
}
