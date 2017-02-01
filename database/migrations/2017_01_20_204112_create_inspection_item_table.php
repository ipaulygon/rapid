<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspect_item', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('inspectItemId');
            $table->string('inspectItemTypeId');
            $table->string('inspectItemName');
            $table->text('inspectItemDesc')->nullable();
            $table->boolean('inspectItemIsActive');
            $table->timestamps();
            $table->primary('inspectItemId');
            $table->foreign('inspectItemTypeId')
                  ->references('inspectTypeId')->on('inspect_type')
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
        Schema::dropIfExists('inspect_item');
    }
}
