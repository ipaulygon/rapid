<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_cost', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('scId');
            $table->float('scCost',8,2);
            $table->timestamps();
            $table->primary('scId');
            $table->foreign('scId')
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
        Schema::dropIfExists('service_cost');
    }
}
