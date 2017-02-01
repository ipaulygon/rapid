<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspect_detail', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('inspectHDId');
            $table->string('inspectItemDId');
            $table->text('inspectDRemarks')->nullable();
            $table->integer('inspectDRating');
            $table->text('inspectDCondition')->nullable();
            $table->primary('inspectHDId');
            $table->foreign('inspectHDId')
                  ->references('inspectHId')->on('inspect_header')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('inspectItemDId')
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
        Schema::dropIfExists('inspect_detail');
    }
}
