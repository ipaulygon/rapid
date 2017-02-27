<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tech_skill', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('tsId');
            $table->string('tsTechId');
            $table->string('tsSkillId');
            $table->tinyInteger('tsIsActive');
            $table->timestamps();
            $table->foreign('tsTechId')
                  ->references('techId')->on('technician')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('tsSkillId')
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
        Schema::dropIfExists('tech_skill');
    }
}
