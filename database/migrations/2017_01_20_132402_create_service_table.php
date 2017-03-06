<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('serviceId');
            $table->string('serviceCategoryId');
            $table->string('serviceName');
            $table->text('serviceDesc')->nullable();
            $table->float('servicePrice', 8, 2);
            $table->tinyInteger('serviceSize');
            $table->boolean('serviceIsActive');
            $table->timestamps();
            $table->primary('serviceId');
            $table->foreign('serviceCategoryId')
                  ->references('categoryId')->on('service_category')
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
        Schema::dropIfExists('service');
    }
}
