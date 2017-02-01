<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVarianceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variance', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('varianceId');
            $table->text('varianceDesc')->nullable();
            $table->text('varianceSize');
            $table->string('varianceUnitId');
            $table->tinyInteger('varianceIsActive');
            $table->timestamps();
            $table->primary('varianceId');
            $table->foreign('varianceUnitId')
                  ->references('unitId')->on('unit')
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
        Schema::dropIfExists('variance');
    }
}
