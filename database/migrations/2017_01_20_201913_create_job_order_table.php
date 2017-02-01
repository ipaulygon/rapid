<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_order', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('jobId');
            $table->string('jobVehicleId');
            $table->string('jobCustomerId');
            $table->boolean('jobIsActive');
            $table->timestamps();
            $table->primary('jobId');
            $table->foreign('jobVehicleId')
                  ->references('vehicleId')->on('vehicle')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('jobCustomerId')
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
        Schema::dropIfExists('job_order');
    }
}
