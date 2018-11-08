<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->decimal('price', 10,2);
            $table->integer('qty');
            
            $table->decimal('discount1', 10,2)->nullable();
            $table->decimal('discount2', 10,2)->nullable();
            $table->decimal('discount3', 10,2)->nullable();
            $table->decimal('discount4', 10,2)->nullable();

            $table->decimal('total_discount', 10,2)->nullable();
            $table->decimal('total_taxes', 10,2)->nullable();

            $table->decimal('pvp', 10,2)->nullable();
            $table->decimal('benefit', 10,2)->nullable();

            $table->decimal('subtotal', 10,2);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('invoice_id')
              ->references('id')->on('invoices')
              ->onDelete('cascade');

            $table->foreign('product_id')
              ->references('id')->on('products')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
    }
}
