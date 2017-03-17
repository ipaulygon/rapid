<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoCostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_cost', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('prId');
            $table->float('prCost',8,2);
            $table->timestamps();
            $table->primary(['prId','prCost','created_at']);
            $table->foreign('prId')
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
        Schema::dropIfExists('promo_cost');
    }
}
