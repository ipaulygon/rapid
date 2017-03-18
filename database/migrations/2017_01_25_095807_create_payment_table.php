<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('paymentInvoiceId');
            $table->double('paymentPaid',10,2);
            $table->timestamps();
            $table->primary('paymentInvoiceId');
            $table->foreign('paymentInvoiceId')
                  ->references('invoiceId')->on('invoice')
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
        Schema::dropIfExists('payment');
    }
}
