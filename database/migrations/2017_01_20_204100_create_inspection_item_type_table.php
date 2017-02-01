<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionItemTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspect_type', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('inspectTypeId');
            $table->string('inspectTypeName');
            $table->text('inspectTypeDesc')->nullable();
            $table->boolean('inspectTypeIsActive');
            $table->timestamps();
            $table->primary('inspectTypeId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspect_type');
    }
}
