<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobPromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_promo', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('jobPrId');
            $table->string('jobPromoId');
            $table->integer('jobPrQty');
            $table->primary(['jobPrId','jobPromoId']);
            $table->foreign('jobPrId')
                  ->references('jobId')->on('job_order')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('jobPromoId')
                  ->references('promoId')->on('promo')
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
        chema::dropIfExists('job_promo');
    }
}
