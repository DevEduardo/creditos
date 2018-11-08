<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->string('reference');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('specification')->nullable();
            $table->string('height');
            $table->string('width');
            $table->string('depth');

            $table->decimal('last_price', 8,2)->nullable();
            $table->decimal('price', 8,2);
            $table->decimal('next_price', 8,2)->nullable();
            $table->boolean('update_price')->default(0);

            $table->string('color')->nullable();
            $table->decimal('original_price', 8,2);
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->integer('stock_minimun');
            $table->integer('company_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('products');
    }
}
