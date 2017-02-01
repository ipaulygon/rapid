<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspect_header', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('inspectHId');
            $table->string('inspectVehicleId');
            $table->string('inspectCustomerId');
            $table->text('inspectProblem')->nullable();
            $table->text('inspectRequest')->nullable();
            $table->text('inspectRemarks')->nullable();
            $table->boolean('inspectIsActive');
            $table->timestamps();
            $table->primary('inspectHId');
            $table->foreign('inspectVehicleId')
                  ->references('vehicleId')->on('vehicle')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('inspectCustomerId')
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
        Schema::dropIfExists('inspect_header');
    }
}
