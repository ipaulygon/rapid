<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('customerId');
            $table->string('customerFirst');
            $table->string('customerMiddle');
            $table->string('customerLast');
            $table->text('customerAddress');
            $table->string('customerEmail')->nullable();
            $table->string('customerContact');
            $table->boolean('customerIsActive');
            $table->timestamps();
            $table->primary('customerId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
}
