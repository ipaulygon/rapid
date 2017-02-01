<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_service', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('jobSId');
            $table->string('jobServiceId');
            $table->primary(['jobSId','jobServiceId']);
            $table->foreign('jobSId')
                  ->references('jobId')->on('job_order')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('jobServiceId')
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
        Schema::dropIfExists('job_service');
    }
}
