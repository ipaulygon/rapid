<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimatePackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_package', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('estimatePcId');
            $table->string('estimatePackageId');
            $table->integer('estimatePcQty');
            $table->primary(['estimatePcId','estimatePackageId']);
            $table->foreign('estimatePcId')
                  ->references('estimateHId')->on('estimate_header')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('estimatePackageId')
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
        Schema::dropIfExists('estimate_package');
    }
}
