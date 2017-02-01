<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('invoiceId');
            $table->string('invoiceJobId');
            $table->string('invoiceDiscountId');
            $table->timestamps();
            $table->primary('invoiceId');
            $table->foreign('invoiceJobId')
                  ->references('jobId')->on('job_order')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->foreign('invoiceDiscountId')
                  ->references('discountId')->on('discount')
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
        Schema::dropIfExists('invoice');
    }
}
