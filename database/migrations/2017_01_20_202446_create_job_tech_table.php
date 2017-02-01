<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobTechTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_tech', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('jobTId');
            $table->string('jobTechId');
            $table->primary(['jobTId','jobTechId']);
            $table->foreign('jobTId')
                  ->references('jobId')->on('job_order')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('jobTechId')
                  ->references('techId')->on('technician')
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
        Schema::dropIfExists('job_tech');
    }
}
