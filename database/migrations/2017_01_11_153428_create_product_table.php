<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('productId');
            $table->string('productBrandId');
            $table->string('productName');
            $table->string('productTypeId');
            $table->text('productDesc')->nullable();
            $table->boolean('productIsActive');
            $table->timestamps();
            $table->primary('productId');
            $table->foreign('productTypeId')
                  ->references('typeId')->on('product_type')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('productBrandId')
                  ->references('brandId')->on('brand')
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
        Schema::dropIfExists('product');
    }
}
