<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionTechTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspect_tech', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('inspectTId');
            $table->string('inspectTechId');
            $table->boolean('inspectTIsActive');
            $table->timestamps();
            $table->primary('inspectTId');
            $table->foreign('inspectTId')
                  ->references('inspectHId')->on('inspect_header')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('inspectTechId')
                  ->references('techId')->on('technician')
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
        Schema::dropIfExists('inspect_tech');
    }
}
