<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('packageId');
            $table->string('packageName');
            $table->text('packageDesc')->nullable();
            $table->double('packageCost',10,2)->nullable();
            $table->boolean('packageIsActive');
            $table->timestamps();
            $table->primary('packageId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package');
    }
}
