<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechnicianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technician', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('techId');
            $table->string('techFirst');
            $table->string('techMiddle');
            $table->string('techLast');
            $table->text('techStreet');
            $table->text('techBrgy');
            $table->text('techCity');
            $table->string('techEmail');
            $table->string('techContact');
            $table->string('techPic');
            $table->boolean('techIsActive');
            $table->timestamps();
            $table->primary('techId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technician');
    }
}
