<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('number')->nullable();
            $table->string('type');
            $table->integer('company_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->decimal('subtotal', 8,2)->nullable();
            $table->decimal('tax', 8,2)->nullable();
            $table->decimal('tax_amount', 8,2)->nullable();
            $table->decimal('discount', 8,2)->nullable();
            $table->decimal('discount_amount', 8,2)->nullable();
            $table->decimal('total', 8,2)->nullable();
            $table->text('observations')->nullable();
            $table->boolean('finished')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')
              ->references('id')->on('companies')
              ->onDelete('cascade');

            $table->foreign('client_id')
              ->references('id')->on('clients')
              ->onDelete('cascade');

              $table->foreign('user_id')
              ->references('id')->on('users')
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
        Schema::dropIfExists('sales');
    }
}
