<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id')->unsigned();
            $table->integer('product_id')->unsigned();

            $table->decimal('price', 8,2);
            $table->integer('qty');
            $table->decimal('subtotal', 8,2);

            $table->decimal('discount', 8,2)->nullable();
            $table->decimal('amount_discount', 8,2)->nullable();

            $table->string('taxes')->nullable();
            $table->decimal('amount_taxes', 8,2)->nullable();

            $table->boolean('finised')->default(0);

            $table->timestamps();

            $table->foreign('sale_id')
              ->references('id')->on('sales')
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
        Schema::dropIfExists('sale_details');
    }
}
