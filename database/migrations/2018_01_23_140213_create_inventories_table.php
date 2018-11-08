<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->increments('id');
            #$table->string('reference')->unique();
            $table->integer('stock');
            #$table->enum('op', ['Entrada', 'Salida']);
            $table->integer('qty');
            $table->integer('product_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->timestamps();

            $table->foreign('product_id')
              ->references('id')->on('products')
              ->onDelete('cascade');

            $table->foreign('company_id')
              ->references('id')->on('companies')
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
        Schema::dropIfExists('inventories');
    }
}
