<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('packagePId');
            $table->unsignedInteger('packageProductId');
            $table->integer('packagePQty')->nullable();
            $table->primary(['packagePId','packageProductId']);
            $table->foreign('packagePId')
                  ->references('packageId')->on('package')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('packageProductId')
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
        Schema::dropIfExists('package_product');
    }
}
