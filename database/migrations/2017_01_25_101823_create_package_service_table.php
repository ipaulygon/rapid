<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_service', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('packageSId');
            $table->string('packageServiceId');
            $table->boolean('packageSIsActive');
            $table->timestamps();
            $table->foreign('packageSId')
                  ->references('packageId')->on('package')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('packageServiceId')
                  ->references('serviceId')->on('service')
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
        Schema::dropIfExists('package_service');
    }
}
