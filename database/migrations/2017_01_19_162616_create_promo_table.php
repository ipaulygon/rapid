<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('promoId');
            $table->string('promoName');
            $table->text('promoDesc')->nullable();
            $table->date('promoStart');
            $table->date('promoEnd');
            $table->boolean('promoIsActive');
            $table->timestamps();
            $table->primary('promoId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo');
    }
}
