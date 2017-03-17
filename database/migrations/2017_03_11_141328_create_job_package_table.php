<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_package', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('jobPcId');
            $table->string('jobPackageId');
            $table->integer('jobPcQty');
            $table->primary(['jobPcId','jobPackageId']);
            $table->foreign('jobPcId')
                  ->references('jobId')->on('job_order')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('jobPackageId')
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
        Schema::dropIfExists('job_package');
    }
}
