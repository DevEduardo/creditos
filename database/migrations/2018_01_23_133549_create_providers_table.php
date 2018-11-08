<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('cuit');
            $table->boolean('is_active');
            $table->integer('profile_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('profile_id')
              ->references('id')->on('profiles')
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
        Schema::dropIfExists('providers');
    }
}
