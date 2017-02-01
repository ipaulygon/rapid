<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendation', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('recommendationId');
            $table->text('recommendationDesc')->nullable();
            $table->foreign('recommendationId')
                  ->references('inspectItemId')->on('inspect_item')
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
        Schema::dropIfExists('recommendation');
    }
}
