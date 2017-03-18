<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_cost', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('pkId');
            $table->double('pkCost',10,2);
            $table->timestamps();
            $table->primary(['pkId','pkCost','created_at']);
            $table->foreign('pkId')
                  ->references('packageId')->on('package')
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
        Schema::dropIfExists('package_cost');
    }
}
