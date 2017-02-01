<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleMakeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_make', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('makeId');
            $table->string('makeName');
            $table->boolean('makeIsActive');
            $table->timestamps();
            $table->primary('makeId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_make');
    }
}
