<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->boolean('default');
            $table->integer('company_id')->unsigned();
            $table->integer('profile_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('company_id')
              ->references('id')->on('companies')
              ->onDelete('cascade');

            $table->foreign('profile_id')
              ->references('id')->on('profiles')
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
        Schema::dropIfExists('stores');
    }
}
