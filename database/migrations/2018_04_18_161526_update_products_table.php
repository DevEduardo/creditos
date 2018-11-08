<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->timestamp('date_update_price')->nullable();
            $table->string('color_secondary')->nullable();
            $table->string('color_tertiary')->nullable();
            $table->boolean('web')->default(0);
            $table->boolean('observation')->default(0);
        });
    }
}