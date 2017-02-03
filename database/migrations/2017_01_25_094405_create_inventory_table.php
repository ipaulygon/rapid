<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('inventoryPvId');
            $table->integer('inventoryQty');
            $table->timestamps();
            $table->primary('inventoryPvId');
            $table->foreign('inventoryPvId')
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
        Schema::dropIfExists('inventory');
    }
}
