<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('jobPId');
            $table->unsignedInteger('jobProductId');
            $table->integer('jobPQty');
            $table->primary(['jobPId','jobProductId']);
            $table->foreign('jobPId')
                  ->references('jobId')->on('job_order')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('jobProductId')
                  ->references('pvId')->on('product_variance')
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
        Schema::dropIfExists('job_product');
    }
}
